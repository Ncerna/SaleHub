<?php
namespace App\Application\UseCase;

use App\Application\Service\ProductAppService;

class ListProductsUseCase {
    private ProductAppService $productAppService;

    public function __construct(ProductAppService $productAppService) {
        $this->productAppService = $productAppService;
    }

    public function execute(): array {
        return $this->productAppService->getAllProducts();
    }
}
