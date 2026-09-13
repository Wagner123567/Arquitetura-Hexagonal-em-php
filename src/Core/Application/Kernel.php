<?php

declare(strict_types=1);

namespace App\Core\Application;

class Kernel
{
    public function handle(): void
    {
        \App\Core\Infrastructure\Database::boot();

        $router = new \App\Core\Infrastructure\Router();
        $loader = new \App\Core\Infrastructure\RouterLoader($router);
        
        $modulesPath = dirname(__DIR__, 3) . '/Modules';
        if (is_dir($modulesPath)) {
            foreach (scandir($modulesPath) as $module) {
                if ($module === '.' || $module === '..') continue;
                if (is_dir($modulesPath . '/' . $module)) {
                    $loader->loadModuleRoutes($module);
                }
            }
        }

        $method = $_SERVER['REQUEST_METHOD'] ?? 'GET';
        $uri = parse_url($_SERVER['REQUEST_URI'] ?? '/', PHP_URL_PATH);

        $router->dispatch($method, $uri);
    }
}
