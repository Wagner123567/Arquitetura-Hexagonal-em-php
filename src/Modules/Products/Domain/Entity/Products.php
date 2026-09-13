<?php declare(strict_types=1);
namespace App\Modules\Products\Domain\Entity;
class Products
{
    public function __construct(private string $id) {}
    public function id(): string { return $this->id; }
}
