<?php

declare(strict_types=1);

namespace App\Core\Infrastructure;

class Router
{
    private array $routes = [];

    public function add(string $method, string $path, callable $handler): void
    {
        $regex = '#^' . preg_replace('#\{[^}]+\}#', '([^/]+)', $path) . '$#';
        $this->routes[] = [
            'method' => strtoupper($method),
            'path' => $path,
            'regex' => $regex,
            'handler' => $handler,
        ];
    }

    public function dispatch(string $method, string $uri): void
    {
        $method = strtoupper($method);
        foreach ($this->routes as $route) {
            if ($route['method'] !== $method) {
                continue;
            }
            if (preg_match($route['regex'], $uri, $matches)) {
                array_shift($matches);
                call_user_func_array($route['handler'], $matches);
                return;
            }
        }
        http_response_code(404);
        header('Content-Type: application/json');
        echo json_encode(['error' => 'Route not found']);
    }

    public function getRoutes(): array
    {
        return $this->routes;
    }
}
