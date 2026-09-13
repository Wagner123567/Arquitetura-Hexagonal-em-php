<?php declare(strict_types=1);
namespace App\Modules\Products\Interface\Http;
use App\Modules\Products\Application\UseCase\GetProductsUseCase;
use App\Modules\Products\Application\UseCase\ListProductsUseCase;
class ProductsController
{
    public function __construct(
        private GetProductsUseCase $get,
        private ListProductsUseCase $list
    ) {}
    public function get(string $id): void
    {
        header('Content-Type: application/json');
        echo json_encode($this->get->execute($id) ?? ['error'=>'not found']);
    }
    public function list(): void
    {
        header('Content-Type: application/json');
        echo json_encode($this->list->execute());
    }
}
