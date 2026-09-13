<?php

declare(strict_types=1);

namespace App\Modules\Users\Infrastructure\Migrations;

use Illuminate\Database\Capsule\Manager as Capsule;

class CreateUsersTable
{
    public function up(): void
    {
        Capsule::schema()->create('users', function ($table) {
            $table->id();
            $table->string('email')->unique();
            $table->string('name');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Capsule::schema()->dropIfExists('users');
    }
}
