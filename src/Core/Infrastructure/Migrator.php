<?php

declare(strict_types=1);

namespace App\Core\Infrastructure;

class Migrator
{
    public static function run(): void
    {
        $migrations = [
            new \App\Modules\Users\Infrastructure\Migrations\CreateUsersTable(),
        ];
        foreach ($migrations as $migration) {
            if (method_exists($migration, 'up')) {
                $migration->up();
            }
        }
    }
}
