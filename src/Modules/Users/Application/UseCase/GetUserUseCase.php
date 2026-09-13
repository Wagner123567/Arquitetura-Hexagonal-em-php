<?php

declare(strict_types=1);

namespace App\Modules\Users\Application\UseCase;

use App\Modules\Users\Domain\Repository\UserRepositoryInterface;

final class GetUserUseCase
{
    public function __construct(private UserRepositoryInterface $repository) {}

    public function execute(string $id): ?array
    {
        $user = $this->repository->findById($id);
        if (!$user) {
            return null;
        }
        return [
            'id' => $user->id(),
            'email' => $user->email(),
            'name' => $user->name(),
        ];
    }
}
