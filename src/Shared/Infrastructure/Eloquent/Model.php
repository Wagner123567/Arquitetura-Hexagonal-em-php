<?php

declare(strict_types=1);

namespace App\Shared\Infrastructure\Eloquent;

use Illuminate\Database\Eloquent\Model as EloquentModel;

abstract class Model extends EloquentModel
{
    protected $guarded = [];
    
    public $timestamps = true;
}
