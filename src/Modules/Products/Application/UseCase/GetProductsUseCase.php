<?php declare(strict_types=1);
namespace App\Modules\Products\Application\UseCase;
use App\Modules\Products\Domain\Repository\ProductsRepositoryInterface;
class GetProductsUseCase
{
    public function __construct(private ProductsRepositoryInterface $repo) {}
    public function execute(string $id): ?array
    {
        $e = $this->repo->findById($id);
        return $e ? ['id' => $e->id()] : null;
    }
}
