<?php

namespace BaptisteDulac\PushNotificationBundle;

use BaptisteDulac\PushNotificationBundle\Message\AndroidMessage;
use BaptisteDulac\PushNotificationBundle\Message\IOSMessage;
use BaptisteDulac\PushNotificationBundle\Sender\AndroidSender;
use BaptisteDulac\PushNotificationBundle\Sender\IOSSender;

class PushNotificationSender
{

    private $android;

    private $iOS;

    private $messages = [];

    public function __construct(AndroidSender $androidSender, IOSSender $iOSSender)
    {
        $this->android = $androidSender;
        $this->iOS = $iOSSender;
    }

    public function addMessage(MessageInterface $message)
    {
        $this->messages[] = $message;
    }

    public function send()
    {
        foreach ($this->messages as $message)
        {
            if ($message instanceof IOSMessage && $this->iOS != null) {
                $this->iOS->send($message);
            } else if ($message instanceof AndroidMessage && $this->android != null) {
                $this->android->send($message);
            }
        }
    }

}