<?php

declare(strict_types=1);

namespace App\Core\Infrastructure;

use Illuminate\Database\Capsule\Manager as Capsule;

class Database
{
    public static function boot(): void
    {
        $capsule = new Capsule;
        $config = require __DIR__ . '/../../../config/database.php';
        $capsule->addConnection($config['connections'][$config['default']]);
        $capsule->setAsGlobal();
        $capsule->bootEloquent();
    }
}
