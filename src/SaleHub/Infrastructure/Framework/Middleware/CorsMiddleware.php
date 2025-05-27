<?php
namespace SaleHub\Infrastructure\Framework\Middleware;

class CorsMiddleware
{
    public function handle(array $serverHeaders, callable $next): void
    {
        header("Access-Control-Allow-Origin: *");
        header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
        header("Access-Control-Allow-Headers: Content-Type, Authorization, Tenant-ID");

        if ($serverHeaders['REQUEST_METHOD'] === 'OPTIONS') {
            http_response_code(204);
            exit;
        }

        $next();
    }
}
