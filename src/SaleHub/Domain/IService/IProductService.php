<?php
namespace SaleHub\Domain\IService;

use SaleHub\Domain\Entity\Product;

interface IProductService {
    public function validateProduct(Product $product): bool;
}
