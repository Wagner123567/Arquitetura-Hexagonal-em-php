<?php
declare(strict_types=1);
require_once __DIR__ . '/../vendor/autoload.php';

use App\Core\Application\Kernel;

$kernel = new Kernel();
$kernel->handle();