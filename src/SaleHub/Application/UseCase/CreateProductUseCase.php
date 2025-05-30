<?php
namespace SaleHub\Application\UseCase;

use SaleHub\Application\Service\ProductAppService;
use SaleHub\Domain\Entity\Product;

class CreateProductUseCase {
    private ProductAppService $productAppService;

    public function __construct(ProductAppService $productAppService) {
        $this->productAppService = $productAppService;
    }

    public function execute(Product $product): bool {
        return $this->productAppService->createProduct($product);
    }
}
