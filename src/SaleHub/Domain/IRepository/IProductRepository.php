<?php
namespace SaleHub\Domain\IRepository;

use SaleHub\Domain\Entity\Product;

interface IProductRepository {
    public function create(Product $product): bool;
    public function update(Product $product): bool;
    public function delete(string $id): bool;
    public function findById(string $id): ?Product;
    public function findAll(): array; // Array de Product
}
