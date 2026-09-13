<?php

declare(strict_types=1);

namespace App\Modules\Users\Application\UseCase;

use App\Modules\Users\Domain\Entity\User;
use App\Modules\Users\Domain\Repository\UserRepositoryInterface;

final class CreateUserUseCase
{
    public function __construct(private UserRepositoryInterface $repository) {}

    public function execute(string $email, string $name): array
    {
        $id = uniqid('u_', true);
        $user = new User($id, $email, $name);
        $this->repository->save($user);
        return [
            'id' => $user->id(),
            'email' => $user->email(),
            'name' => $user->name(),
        ];
    }
}
