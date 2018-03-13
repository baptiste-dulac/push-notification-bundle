<?php

namespace BaptisteDulac\PushNotificationBundle\Message;

use BaptisteDulac\PushNotificationBundle\MessageInterface;

abstract class AbstractMessage implements MessageInterface
{

    private $id;

    private $title;

    private $message;

    private $devices = [];

    public function __construct(string $id, string $title, string $message)
    {
        $this->id = $id;
        $this->title = $title;
        $this->message = $message;
    }

    public function addDevice(string $id)
    {
        $this->devices[] = $id;
    }

    public function id(): string
    {
        return $this->id;
    }

    public function title(): string
    {
        return $this->title;
    }

    public function message(): string
    {
        return $this->message;
    }

    public function devices(): array
    {
        return $this->devices;
    }

}