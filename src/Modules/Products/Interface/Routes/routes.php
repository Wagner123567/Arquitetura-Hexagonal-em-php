<?php declare(strict_types=1);
use App\Modules\Products\Infrastructure\Repository\EloquentProductsRepository;
use App\Modules\Products\Application\UseCase\GetProductsUseCase;
use App\Modules\Products\Application\UseCase\ListProductsUseCase;
use App\Modules\Products\Interface\Http\ProductsController;

$repo = new EloquentProductsRepository();
$controller = new ProductsController(
    new GetProductsUseCase($repo),
    new ListProductsUseCase($repo)
);

return [
    ['method'=>'GET','path'=>'/Products/{id}','handler'=>fn($id)=>$controller->get($id)],
    ['method'=>'GET','path'=>'/Products','handler'=>fn()=>$controller->list()],
];
