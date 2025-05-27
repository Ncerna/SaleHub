<?php
namespace SaleHub\Infrastructure\ApiClients;

class ExternalEmailVerificationClient {
    public function verifyEmail(string $email): bool {
        // Simula llamada a API externa para verificar email
        // Aquí siempre devuelve true para el ejemplo
        return true;
    }
}
