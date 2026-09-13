<?php

declare(strict_types=1);

namespace App\Core\Application;

interface EventBusInterface
{
    public function dispatch(object $event): void;
    public function subscribe(string $eventClass, callable $handler): void;
}
