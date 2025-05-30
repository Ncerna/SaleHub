<?php
namespace SaleHub\Application\UseCase;

use SaleHub\Application\Service\ProductAppService;
use SaleHub\Domain\Entity\Product;

class GetProductUseCase {
    private ProductAppService $productAppService;

    public function __construct(ProductAppService $productAppService) {
        $this->productAppService = $productAppService;
    }

    public function execute(string $id): ?Product {
        return $this->productAppService->getProductById($id);
    }
}
