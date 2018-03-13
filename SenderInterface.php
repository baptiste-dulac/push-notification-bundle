<?php

namespace BaptisteDulac\PushNotificationBundle;

interface SenderInterface
{

    public function send(MessageInterface $message): void;

}