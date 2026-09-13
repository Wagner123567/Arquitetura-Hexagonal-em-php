<?php declare(strict_types=1);
namespace App\Modules\Products\Infrastructure\Eloquent;
use App\Shared\Infrastructure\Eloquent\Model;
class ProductsModel extends Model
{
    protected $table = 'Products';
    protected $fillable = [];
}
