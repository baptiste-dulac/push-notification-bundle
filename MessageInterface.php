<?php

namespace BaptisteDulac\PushNotificationBundle;

interface MessageInterface
{

    public function __construct(string $id, string $title, string $message);

    public function id(): string;

    public function title(): string;

    public function message(): string;

    public function devices(): array;

}