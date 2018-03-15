<?php

namespace BaptisteDulac\PushNotificationBundle\Sender;

use BaptisteDulac\PushNotificationBundle\MessageInterface;
use BaptisteDulac\PushNotificationBundle\SenderInterface;

class IOSSender implements SenderInterface
{
    private $pem;

    private $passPhrase;

    private $sandbox;

    private $timeout;

    const SANDBOX_ENDPOINT = "ssl://gateway.sandbox.push.apple.com:2195";

    const ENDPOINT = "ssl://gateway.push.apple.com:2195";

    public function __construct(string $pem, string $passPhrase, bool $sandbox = false, $timeout = 60)
    {
        $this->pem = $pem;
        $this->passPhrase = $passPhrase;
        $this->sandbox = $sandbox;
        $this->timeout = $timeout;
    }

    private function buildPlayload(MessageInterface $message): string
    {
        return json_encode([
            'aps' => [
                'alert' => [
                    'title' => $message->title(),
                    'body' => $message->message(),
                ],
                'badge' => 0,
                'sound' => 'default',
            ]
        ]);
    }

    private function buildRequest(string $playload, string $device)
    {
        $ctx = stream_context_create();
        stream_context_set_option($ctx, 'ssl', 'local_cert', $this->pem);
        stream_context_set_option($ctx, 'ssl', 'passphrase', $this->passPhrase);
        $fp = stream_socket_client(
            $this->sandbox ? self::SANDBOX_ENDPOINT : self::ENDPOINT,
            $err,
            $errstr,
            $this->timeout,
            STREAM_CLIENT_CONNECT|STREAM_CLIENT_PERSISTENT,
            $ctx
        );

        if (!$fp)
            throw new \RuntimeException("Failed to connect: $err $errstr" . PHP_EOL);

        $data = chr(0)
                .pack('n', 32)
                .pack('H*', $device)
                .pack('n', strlen($playload))
                .$playload;
        $result = fwrite($fp, $data, strlen($data));

        if (!$result)
            throw new \RuntimeException("Message was not delivered");

        fclose($fp);
    }

    public function send(MessageInterface $message): void
    {
        $playload = $this->buildPlayload($message);
        foreach ($message->devices() as $device)
        $this->buildRequest($playload, $device);
    }
}