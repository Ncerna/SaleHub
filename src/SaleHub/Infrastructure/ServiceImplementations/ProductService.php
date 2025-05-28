<?php
namespace SaleHub\Infrastructure\ServiceImplementations;

use SaleHub\Domain\Entity\Product;
use SaleHub\Domain\IService\IProductService;
use SaleHub\Infrastructure\ApiClients\BarcodeValidationClient;

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
