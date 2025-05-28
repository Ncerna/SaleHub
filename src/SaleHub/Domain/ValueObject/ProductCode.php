<?php
namespace SaleHub\Domain\ValueObject;

use InvalidArgumentException;

class ProductCode {
    private string $code;

    public function __construct(string $code) {
        if (!preg_match('/^[A-Z0-9\-]+$/', $code)) {
            throw new InvalidArgumentException("Código de producto inválido");
        }
        $this->code = $code;
    }

    public function __toString(): string {
        return $this->code;
    }
}
