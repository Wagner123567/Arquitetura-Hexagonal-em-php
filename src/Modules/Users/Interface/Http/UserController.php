<?php

declare(strict_types=1);

namespace App\Modules\Users\Interface\Http;

use App\Modules\Users\Application\UseCase\CreateUserUseCase;
use App\Modules\Users\Application\UseCase\GetUserUseCase;
use App\Modules\Users\Application\UseCase\ListUsersUseCase;
use App\Shared\Infrastructure\View\Renderer;

class UserController
{
    public function __construct(
        private GetUserUseCase $getUser,
        private ListUsersUseCase $listUsers,
        private CreateUserUseCase $createUser
    ) {}

    public function get(string $id): void
    {
        $data = $this->getUser->execute($id);
        header('Content-Type: application/json');
        echo json_encode($data ?? ['error' => 'not found'], JSON_THROW_ON_ERROR);
    }

    public function list(): void
    {
        $data = $this->listUsers->execute();
        header('Content-Type: application/json');
        echo json_encode($data, JSON_THROW_ON_ERROR);
    }

    public function create(): void
    {
        $email = $_POST['email'] ?? '';
        $name = $_POST['name'] ?? '';
        if (!$email || !$name) {
            http_response_code(400);
            echo json_encode(['error' => 'email e name obrigatórios']);
            return;
        }
        $this->createUser->execute($email, $name);
        header('Location: /users/view', true, 302);
        exit;
    }

    public function showListView(): void
    {
        $users = $this->listUsers->execute();
        $html = Renderer::render(__DIR__ . '/../Views/users/list.php', ['users' => $users]);
        header('Content-Type: text/html; charset=utf-8');
        echo $html;
    }

    public function showCreateForm(): void
    {
        $html = Renderer::render(__DIR__ . '/../Views/users/create.php');
        header('Content-Type: text/html; charset=utf-8');
        echo $html;
    }
}
