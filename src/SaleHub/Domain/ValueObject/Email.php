<?php
namespace SaleHub\Domain\ValueObject;

use InvalidArgumentException;

class Email {
    private string $email;

    public function __construct(string $email) {
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            throw new InvalidArgumentException("Email inválido: {$email}");
        }
        $this->email = strtolower(trim($email));
    }

    public function __toString(): string {
        return $this->email;
    }
}
