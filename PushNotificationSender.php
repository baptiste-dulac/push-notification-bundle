<?php

namespace BaptisteDulac\PushNotificationBundle;

use BaptisteDulac\PushNotificationBundle\Sender\AndroidSender;
use BaptisteDulac\PushNotificationBundle\Sender\IOSSender;

class PushNotificationSender
{

    private $android;

    private $iOS;

    public function __construct(AndroidSender $androidSender = null, IOSSender $iOSSender = null)
    {
        $this->android = $androidSender;
        $this->iOS = $iOSSender;
    }

    public function addMessage(MessageInterface $message)
    {

    }

    public function send()
    {

    }

}