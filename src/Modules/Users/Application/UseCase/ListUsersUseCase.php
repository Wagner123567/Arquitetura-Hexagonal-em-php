<?php

declare(strict_types=1);

namespace App\Modules\Users\Application\UseCase;

use App\Modules\Users\Domain\Repository\UserRepositoryInterface;

final class ListUsersUseCase
{
    public function __construct(private UserRepositoryInterface $repository) {}

    public function execute(): array
    {
        // Repository precisa de método listAll
        if (method_exists($this->repository, 'listAll')) {
            $users = $this->repository->listAll();
            return array_map(fn($u) => [
                'id' => $u->id(),
                'email' => $u->email(),
                'name' => $u->name(),
            ], $users);
        }
        return [];
    }
}
