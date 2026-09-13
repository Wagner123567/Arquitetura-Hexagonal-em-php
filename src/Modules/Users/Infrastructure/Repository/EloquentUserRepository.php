<?php

declare(strict_types=1);

namespace App\Modules\Users\Infrastructure\Repository;

use App\Modules\Users\Domain\Entity\User;
use App\Modules\Users\Domain\Repository\UserRepositoryInterface;
use App\Modules\Users\Infrastructure\Eloquent\UserModel;

class EloquentUserRepository implements UserRepositoryInterface
{
    public function findById(string $id): ?User
    {
        $model = UserModel::find($id);
        if (!$model) {
            return null;
        }
        return new User((string)$model->id, $model->email, $model->name);
    }

    public function save(User $user): void
    {
        UserModel::updateOrCreate(
            ['id' => $user->id()],
            ['email' => $user->email(), 'name' => $user->name()]
        );
    }

    public function listAll(): array
    {
        $models = UserModel::all();
        $users = [];
        foreach ($models as $model) {
            $users[] = new User((string)$model->id, $model->email, $model->name);
        }
        return $users;
    }
}
