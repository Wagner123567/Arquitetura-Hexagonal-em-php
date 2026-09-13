<?php declare(strict_types=1);
namespace App\Modules\Products\Domain\Repository;
use App\Modules\Products\Domain\Entity\Products;
interface ProductsRepositoryInterface
{
    public function findById(string $id): ?Products;
    public function save(Products $entity): void;
    public function listAll(): array;
}
