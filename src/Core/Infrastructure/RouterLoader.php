<?php

declare(strict_types=1);

namespace App\Core\Infrastructure;

class RouterLoader
{
    public function __construct(private Router $router) {}

    public function loadModuleRoutes(string $moduleName): void
    {
        $path = __DIR__ . "/../../Modules/{$moduleName}/Interface/Routes/routes.php";
        if (!file_exists($path)) {
            return;
        }
        $routes = include $path;
        foreach ($routes as $route) {
            $this->router->add($route['method'], $route['path'], $route['handler']);
        }
    }
}
