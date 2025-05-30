<?php
namespace App\Application\UseCase;

use App\Application\Service\ProductAppService;
use App\Domain\Entity\Product;

class UpdateProductUseCase {
    private ProductAppService $productAppService;

    public function __construct(ProductAppService $productAppService) {
        $this->productAppService = $productAppService;
    }

    public function execute(Product $product): bool {
        return $this->productAppService->updateProduct($product);
    }
}
