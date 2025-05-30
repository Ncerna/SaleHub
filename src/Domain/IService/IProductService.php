<?php
namespace App\Domain\IService;

use App\Domain\Entity\Product;

interface IProductService {
    public function validateProduct(Product $product): bool;
}
