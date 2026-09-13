<?php

declare(strict_types=1);

namespace App\Shared\Infrastructure\View;

class Renderer
{
    public static function render(string $template, array $data = []): string
    {
        extract($data, EXTR_SKIP);
        ob_start();
        include $template;
        return ob_get_clean();
    }
}
