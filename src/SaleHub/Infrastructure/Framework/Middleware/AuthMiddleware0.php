<?php
namespace SaleHub\Infrastructure\Framework\Middleware;

class AuthMiddleware
{
    public function validateToken(?string $token): bool
    {
        return $token === 'mi-token-secreto'; // Ejemplo simple
    }

    public function handle(array $serverHeaders, callable $next): void
    {
        $token = $serverHeaders['HTTP_AUTHORIZATION'] ?? null;

        if ($token !== null && str_starts_with($token, 'Bearer ')) {
            $token = substr($token, 7);
        }

        if (!$this->validateToken($token)) {
            http_response_code(401);
            echo json_encode(['error' => 'Token inválido o no proporcionado']);
            exit;
        }

        $next();
    }
}

