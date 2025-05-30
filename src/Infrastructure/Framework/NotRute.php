<?php
namespace App\Infrastructure\Framework;


use App\Infrastructure\Framework\Controller\UserController;
use App\Infrastructure\Framework\Middleware\AuthMiddleware;

class Router_0 {
    private UserController $userController;
    private AuthMiddleware $authMiddleware;

    public function __construct(string $tenantIdentifier) {
        $this->userController = new UserController($tenantIdentifier);
        $this->authMiddleware = new AuthMiddleware();
    }

     private array $routes = [];

    public function addRoute(string $method, string $path, callable $handler): void {
        $this->routes[$method][$path] = $handler;
    }

    public function dispatch(): void {
        $method = $_SERVER['REQUEST_METHOD'];
        $uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

        // Opción: quitar subdirectorio como /App/public si es necesario
        $basePath = '/App/public';
        $uri = str_replace($basePath, '', $uri);

        if (isset($this->routes[$method][$uri])) {
            $handler = $this->routes[$method][$uri];
            call_user_func($handler);  // Aquí llama a createUser()
        } else {
            http_response_code(404);
            echo json_encode(["status" => "error", "message" => "Ruta no encontrada"]);
        }
    }

    public function handleRequest(): void {
        $this->authMiddleware->handle(function () {
            $uri = $_SERVER['REQUEST_URI'];
            $method = $_SERVER['REQUEST_METHOD'];

            if ($uri === '/App/public/register' && $method === 'POST') {
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
