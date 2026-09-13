<?php
declare(strict_types=1);
require __DIR__ . '/../vendor/autoload.php';
\App\Core\Infrastructure\Database::boot();
\App\Core\Infrastructure\Migrator::run();
echo "Migrations executed\n";
