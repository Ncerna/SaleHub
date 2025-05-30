<?php
namespace App\Infrastructure\ApiClients;

class BarcodeValidationClient {
    public function validate(string $barcode): bool {
        // Simula llamada a API externa para validar código de barras
        return true;
    }
}
