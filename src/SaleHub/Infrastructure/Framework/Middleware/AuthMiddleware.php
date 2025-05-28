<?php
namespace SaleHub\Infrastructure\Framework\Middleware;

class AuthMiddleware {
    public function handle(callable $next): void {
        // Ejemplo simple: verificar token en headers
        $headers = getallheaders();
        if (!isset($headers['Authorization']) || $headers['Authorization'] !== 'Bearer valid_token') {
          //  http_response_code(401);
           // echo json_encode(['status' => 'error', 'message' => 'No autorizado']);
           // exit;
        }
        $next();
    }
}
