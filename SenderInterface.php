<?php

namespace BaptisteDulac\PushNotificationsBundle;

interface SenderInterface
{

    public function send(array $messages, array $devicesIdentifier);

}