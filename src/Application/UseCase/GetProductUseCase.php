<?php
namespace App\Application\UseCase;

use App\Application\Service\ProductAppService;
use App\Domain\Entity\Product;

class GetProductUseCase {
    private ProductAppService $productAppService;

    public function __construct(ProductAppService $productAppService) {
        $this->productAppService = $productAppService;
    }

    public function execute(string $id): ?Product {
        return $this->productAppService->getProductById($id);
    }
}
