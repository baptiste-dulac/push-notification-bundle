<?php

namespace BaptisteDulac\PushNotificationBundle;

interface SenderInterface
{

    public function send(array $messages, array $devicesIdentifier);

}