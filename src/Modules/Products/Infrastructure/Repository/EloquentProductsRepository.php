<?php declare(strict_types=1);
namespace App\Modules\Products\Infrastructure\Repository;
use App\Modules\Products\Domain\Entity\Products;
use App\Modules\Products\Domain\Repository\ProductsRepositoryInterface;
use App\Modules\Products\Infrastructure\Eloquent\ProductsModel;
class EloquentProductsRepository implements ProductsRepositoryInterface
{
    public function findById(string $id): ?Products
    {
        $model = ProductsModel::find($id);
        return $model ? new Products($model->id) : null;
    }
    public function save(Products $entity): void
    {
        ProductsModel::updateOrCreate(['id' => $entity->id()]);
    }
    public function listAll(): array
    {
        $models = ProductsModel::all();
        $items = [];
        foreach ($models as $m) { $items[] = new Products($m->id); }
        return $items;
    }
}
