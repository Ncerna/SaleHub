<?php
namespace SaleHub\Infrastructure\Framework;

use SaleHub\Infrastructure\Framework\Middleware\CorsMiddleware;
use SaleHub\Infrastructure\Framework\Middleware\TenantMiddleware;
use SaleHub\Infrastructure\Framework\Middleware\AuthMiddleware;

class Router
{
    private array $routes = [];

    public function addRoute(string $method, string $path, callable $handler)
    {
        $this->routes[$method][$path] = $handler;
    }

    public function dispatch()
    {
        $method = $_SERVER['REQUEST_METHOD'];
        $path = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

        $cors = new CorsMiddleware();
        $tenants = include __DIR__ . '/../../../config/tenants.php';
        $tenantMiddleware = new TenantMiddleware($tenants);
        $auth = new AuthMiddleware();

        $handler = $this->routes[$method][$path] ?? null;

        if (!$handler) {
            http_response_code(404);
            echo json_encode(['error' => 'Ruta no encontrada']);
            exit;
        }

        $cors->handle($_SERVER, function () use ($tenantMiddleware, $auth, $handler) {
            $tenantMiddleware->handle($_SERVER, function () use ($auth, $handler) {
                $auth->handle($_SERVER, function () use ($handler) {
                    // Llamada directa al handler
                    $handler();
                });
            });
        });
    }
}
