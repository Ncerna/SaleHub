<?php
namespace SaleHub\Application\UseCase;

use SaleHub\Application\Service\ProductAppService;

class ListProductsUseCase {
    private ProductAppService $productAppService;

    public function __construct(ProductAppService $productAppService) {
        $this->productAppService = $productAppService;
    }

    public function execute(): array {
        return $this->productAppService->getAllProducts();
    }
}
