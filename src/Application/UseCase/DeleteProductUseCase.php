<?php
namespace App\Application\UseCase;

use App\Application\Service\ProductAppService;

class DeleteProductUseCase {
    private ProductAppService $productAppService;

    public function __construct(ProductAppService $productAppService) {
        $this->productAppService = $productAppService;
    }

    public function execute(string $id): bool {
        return $this->productAppService->deleteProduct($id);
    }
}
