<?php
namespace SaleHub\Infrastructure\Framework\Controller;

use SaleHub\Application\UseCase\CreateProductUseCase;
use SaleHub\Application\UseCase\GetProductUseCase;
use SaleHub\Application\UseCase\ListProductsUseCase;
use SaleHub\Infrastructure\Framework\Adapters\JsonResponseAdapter;

class ProductController {
    private CreateProductUseCase $createUseCase;
    private GetProductUseCase $getUseCase;
    private ListProductsUseCase $listUseCase;
    private JsonResponseAdapter $responseAdapter;

    public function __construct(
        CreateProductUseCase $createUseCase,
        GetProductUseCase $getUseCase,
        ListProductsUseCase $listUseCase
    ) {
        $this->createUseCase = $createUseCase;
        $this->getUseCase = $getUseCase;
        $this->listUseCase = $listUseCase;
        $this->responseAdapter = new JsonResponseAdapter();
    }

    public function create(array $data): void {
        try {
            // Mapea el array a entidad Product (simplificado)
            $product = /* ... crear entidad Product ... */;
            $this->createUseCase->execute($product);
            $this->responseAdapter->sendSuccess("Producto creado correctamente.");
        } catch (\Exception $e) {
            $this->responseAdapter->sendError($e->getMessage());
        }
    }

    // Métodos get, list, update, delete similares...
}
