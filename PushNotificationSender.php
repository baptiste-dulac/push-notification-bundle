<?php

namespace AppBundle\Notification\PushNotification;

use BaptisteDulac\PushNotificationsBundle\MessageInterface;
use BaptisteDulac\PushNotificationsBundle\Sender\AndroidSender;
use BaptisteDulac\PushNotificationsBundle\Sender\IOSSender;

class PushNotificationSender
{

    private $android;

    private $iOS;

    public function __construct(AndroidSender $androidSender, IOSSender $iOSSender)
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