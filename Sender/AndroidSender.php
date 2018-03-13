<?php

namespace BaptisteDulac\PushNotificationBundle\Sender;

use BaptisteDulac\PushNotificationBundle\MessageInterface;
use BaptisteDulac\PushNotificationBundle\SenderInterface;

class AndroidSender implements SenderInterface
{

    private $apiKey;

    private $timeout;

    public function __construct(string $apiKey, string $timeout)
    {
        $this->apiKey = $apiKey;
        $this->timeout = $timeout;
    }


    public function send(MessageInterface $message): void
    {
        $headers = [
            'Authorization: key=' . $this->apiKey,
            'Content-Type: application/json'
        ];

        $data =  [
            'data' => [
                "title" => $message->title(),
                "message" => $message->message(),
                "notId" => $message->id()
            ],
            'registration_ids' => $message->devices(),
        ];

        $ch = curl_init();
        curl_setopt( $ch,CURLOPT_URL, 'https://android.googleapis.com/gcm/send' );
        curl_setopt( $ch,CURLOPT_POST, true );
        curl_setopt( $ch,CURLOPT_HTTPHEADER, $headers );
        curl_setopt( $ch,CURLOPT_RETURNTRANSFER, true );
        curl_setopt( $ch,CURLOPT_SSL_VERIFYPEER, false );
        curl_setopt( $ch,CURLOPT_POSTFIELDS, json_encode( $data ) );
        $result = curl_exec($ch );
        curl_close( $ch );
    }
}