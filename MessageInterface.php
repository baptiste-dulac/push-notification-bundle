<?php

namespace BaptisteDulac\PushNotificationsBundle;

interface MessageInterface
{

    public function __construct(string $title, string $message);

    public function title(): string;

    public function message(): string;

}