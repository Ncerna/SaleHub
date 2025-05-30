<?php
namespace App\Infrastructure\ServiceImplementations;

use App\Domain\Entity\Product;
use App\Domain\IService\IProductService;
use App\Infrastructure\ApiClients\BarcodeValidationClient;

class ProductService implements IProductService {
    private BarcodeValidationClient $barcodeClient;

    public function __construct(BarcodeValidationClient $barcodeClient) {
        $this->barcodeClient = $barcodeClient;
    }

    public function validateProduct(Product $product): bool {
        if ($product->getBarcode() !== null) {
            return $this->barcodeClient->validate($product->getBarcode());
        }
        return true;
    }
}
