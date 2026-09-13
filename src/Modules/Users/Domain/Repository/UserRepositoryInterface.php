<?php

declare(strict_types=1);

namespace App\Modules\Users\Domain\Repository;

use App\Modules\Users\Domain\Entity\User;

interface UserRepositoryInterface
{
    public function findById(string $id): ?User;
    public function save(User $user): void;
    public function listAll(): array;
}
