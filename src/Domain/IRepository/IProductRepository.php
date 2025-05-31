<?php
namespace App\Domain\IRepository;

use App\Domain\Entity\Product;

interface IProductRepository {
    public function create(Product $product): bool;
    public function update(Product $product): bool;
    public function delete(string $id): bool;
    public function findById(string $id): ?Product;
    public function findAll(int $page, int $size): array; // Array de Product
}
