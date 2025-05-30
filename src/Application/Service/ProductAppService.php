<?php
namespace App\Application\Service;

use App\Domain\IRepository\IProductRepository;
use App\Domain\Entity\Product;

class ProductAppService {
    private IProductRepository $productRepository;

    public function __construct(IProductRepository $productRepository) {
        $this->productRepository = $productRepository;
    }

    public function createProduct(Product $product): bool {
        return $this->productRepository->create($product);
    }

    public function updateProduct(Product $product): bool {
        return $this->productRepository->update($product);
    }

    public function deleteProduct(string $id): bool {
        return $this->productRepository->delete($id);
    }

    public function getProductById(string $id): ?Product {
        return $this->productRepository->findById($id);
    }

    public function getAllProducts(): array {
        return $this->productRepository->findAll();
    }
}
