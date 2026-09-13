<?php

declare(strict_types=1);

namespace App\Modules\Users\Domain\Entity;

class User
{
    public function __construct(
        private string $id,
        private string $email,
        private string $name
    ) {}

    public function id(): string { return $this->id; }
    public function email(): string { return $this->email; }
    public function name(): string { return $this->name; }
}
