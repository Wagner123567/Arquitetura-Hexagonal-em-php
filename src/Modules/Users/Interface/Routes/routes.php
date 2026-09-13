<?php

declare(strict_types=1);

use App\Modules\Users\Infrastructure\Repository\EloquentUserRepository;
use App\Modules\Users\Application\UseCase\CreateUserUseCase;
use App\Modules\Users\Application\UseCase\GetUserUseCase;
use App\Modules\Users\Application\UseCase\ListUsersUseCase;
use App\Modules\Users\Interface\Http\UserController;

$repo = new EloquentUserRepository();
$getUser = new GetUserUseCase($repo);
$listUsers = new ListUsersUseCase($repo);
$createUser = new CreateUserUseCase($repo);
$controller = new UserController($getUser, $listUsers, $createUser);

return [
    [
        'method' => 'GET',
        'path' => '/users/{id}',
        'handler' => function ($id) use ($controller) {
            $controller->get($id);
        },
    ],
    [
        'method' => 'GET',
        'path' => '/users',
        'handler' => function () use ($controller) {
            $controller->list();
        },
    ],
    [
        'method' => 'GET',
        'path' => '/users/view',
        'handler' => function () use ($controller) {
            $controller->showListView();
        },
    ],
    [
        'method' => 'GET',
        'path' => '/users/create',
        'handler' => function () use ($controller) {
            $controller->showCreateForm();
        },
    ],
    [
        'method' => 'POST',
        'path' => '/users',
        'handler' => function () use ($controller) {
            $controller->create();
        },
    ],
];
