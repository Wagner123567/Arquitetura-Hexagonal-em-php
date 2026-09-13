<?php declare(strict_types=1);
namespace App\Modules\Products\Application\UseCase;
use App\Modules\Products\Domain\Repository\ProductsRepositoryInterface;
class ListProductsUseCase
{
    public function __construct(private ProductsRepositoryInterface $repo) {}
    public function execute(): array
    {
        return array_map(fn($e)=>['id'=>$e->id()], $this->repo->listAll());
    }
}
