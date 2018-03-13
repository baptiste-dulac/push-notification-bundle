<?php

namespace BaptisteDulac\PushNotificationsBundle\Message;

use BaptisteDulac\PushNotificationsBundle\MessageInterface;

class AndroidMessage implements MessageInterface
{

    private $title;

    private $message;

    public function __construct(string $title, string $message)
    {
        $this->title = $title;
        $this->message = $message;
    }

    public function title(): string
    {
        return $this->title;
    }

    public function message(): string
    {
        return $this->message;
    }

}