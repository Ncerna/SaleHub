<?php
namespace SaleHub\Infrastructure\Framework;

use SaleHub\Infrastructure\Framework\Controller\UserController;
use SaleHub\Infrastructure\Framework\Middleware\AuthMiddleware;

class Router {
    private UserController $userController;
    private AuthMiddleware $authMiddleware;

    public function __construct(string $tenantIdentifier) {
        $this->userController = new UserController($tenantIdentifier);
        $this->authMiddleware = new AuthMiddleware();
    }

    public function handleRequest(): void {
        $this->authMiddleware->handle(function () {
            $uri = $_SERVER['REQUEST_URI'];
            $method = $_SERVER['REQUEST_METHOD'];

            if ($uri === '/register' && $method === 'POST') {
                $data = json_decode(file_get_contents('php://input'), true);
                $this->userController->register($data);
            } elseif (preg_match('/\/user\/(.+)/', $uri, $matches) && $method === 'GET') {
                $email = urldecode($matches[1]);
                $this->userController->find($email);
            } else {
                http_response_code(404);
                echo json_encode(['status' => 'error', 'message' => 'Ruta no encontrada']);
            }
        });
    }
}
