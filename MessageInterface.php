<?php

namespace BaptisteDulac\PushNotificationBundle;

interface MessageInterface
{

    public function __construct(string $title, string $message);

    public function title(): string;

    public function message(): string;

}