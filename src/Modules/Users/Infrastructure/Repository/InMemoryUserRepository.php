<?php

declare(strict_types=1);

namespace App\Modules\Users\Infrastructure\Repository;

use App\Modules\Users\Domain\Entity\User;
use App\Modules\Users\Domain\Repository\UserRepositoryInterface;

class InMemoryUserRepository implements UserRepositoryInterface
{
    private array $users = [];

    public function __construct()
    {
        $this->users['1'] = new User('1', 'demo@example.com', 'Demo User');
    }

    public function findById(string $id): ?User
    {
        return $this->users[$id] ?? null;
    }

    public function save(User $user): void
    {
        $this->users[$user->id()] = $user;
    }
}
