<?php
namespace App\Infrastructure\Framework\Controller;

use App\Application\UseCase\CreateProductUseCase;
use App\Application\UseCase\UpdateProductUseCase;
use App\Application\UseCase\DeleteProductUseCase;
use App\Application\UseCase\GetProductUseCase;
use App\Application\UseCase\ListProductsUseCase;
use App\Domain\Entity\Product;
use App\Infrastructure\Framework\Adapters\JsonResponseAdapter;

class ProductController {
    private CreateProductUseCase $createUseCase;
    private UpdateProductUseCase $updateUseCase;
    private DeleteProductUseCase $deleteUseCase;
    private GetProductUseCase $getUseCase;
    private ListProductsUseCase $listUseCase;
    private JsonResponseAdapter $responseAdapter;

    public function __construct(
        CreateProductUseCase $createUseCase,
        UpdateProductUseCase $updateUseCase,
        DeleteProductUseCase $deleteUseCase,
        GetProductUseCase $getUseCase,
        ListProductsUseCase $listUseCase
    ) {
        $this->createUseCase = $createUseCase;
        $this->updateUseCase = $updateUseCase;
        $this->deleteUseCase = $deleteUseCase;
        $this->getUseCase = $getUseCase;
        $this->listUseCase = $listUseCase;
        $this->responseAdapter = new JsonResponseAdapter();
    }

    public function create(array $data): void {
        try {
            $product = $this->mapDataToProduct($data);
            $this->createUseCase->execute($product);
            $this->responseAdapter->sendSuccess("Producto creado correctamente.");
        } catch (\Exception $e) {
            $this->responseAdapter->sendError($e->getMessage());
        }
    }

    // Métodos update, delete, get, list similares

    private function mapDataToProduct(array $data): Product {
        // Aquí deberías validar y mapear correctamente, este es un ejemplo simplificado
        return new Product(
            $data['id'],
            $data['name'],
            $data['code'],
            $data['barcode'] ?? null,
            $data['price'],
            $data['description'] ?? null,
            $data['stock'],
            $data['minimum_stock'],
            $data['id_concept'] ?? null,
            $data['photo'] ?? null,
            $data['categoryId'] ?? null,
            $data['igvAffectationId'] ?? null,
            $data['igvAffectCode'] ?? null,
            $data['unitId'] ?? null,
            $data['unit'] ?? null,
            $data['unitCost'],
            $data['unitPrice'],
            $data['priceWithIgv'],
            $data['priceWithoutIgv'],
            $data['bulkPriceWithIgv'],
            $data['bulkPriceWithoutIgv'],
            $data['offerPriceWithIgv'],
            $data['offerPriceWithoutIgv'],
            $data['totalCost'],
            $data['igvFactor'],
            $data['igvRate'],
            $data['companyId'] ?? null,
            $data['branchId'] ?? null,
            $data['warehouseId'] ?? null,
            new \DateTime($data['createdAt'] ?? 'now'),
            new \DateTime($data['updatedAt'] ?? 'now')
        );
    }
}
