<?php

declare(strict_types=1);

namespace App\Modules\Users\Infrastructure\Eloquent;

use App\Shared\Infrastructure\Eloquent\Model;

class UserModel extends Model
{
    protected $table = 'users';
    protected $fillable = ['email', 'name'];
}
