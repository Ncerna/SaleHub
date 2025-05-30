<?php
require __DIR__ . '/../vendor/autoload.php';

use SaleHub\Infrastructure\Framework\Router;
use SaleHub\Infrastructure\Framework\Controller\UserController;
use SaleHub\Infrastructure\Framework\Controller\InvoiceController;
use SaleHub\Infrastructure\Framework\Controller\SalesController;
// index.php - API REST simple en PHP puro

// Habilitar CORS para pruebas locales (opcional, pero recomendado)
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type");

require_once __DIR__ . '/../core/Router.php';
require_once __DIR__ . '/../controllers/SalesController.php';



// Detectar tenant por subdominio (ejemplo: cliente1.tuapp.com)
$host = $_SERVER['HTTP_HOST'];
$parts = explode('.', $host);
if (count($parts) >= 3) {
    $tenant = $parts[0];
} else {
    // Si no hay subdominio, usa uno por defecto para desarrollo local
    $tenant = 'cliente1';
}

$router = new Router();
$controller = new SalesController();

$router->addRoute('GET', '/', function() use ($tenant) {
    header('Content-Type: application/json');
    echo json_encode([
        'message' => "Bienvenido a la API REST del tenant: $tenant"
    ]);
});

$router->addRoute('POST', '/sales/save', function() use ($controller, $tenant) {
    $controller->save($tenant);
});
$router->addRoute('GET', '/sales/list', function() use ($controller, $tenant) {
    $controller->list($tenant);
});
$router->addRoute('GET', '/sales/get', function() use ($controller, $tenant) {
    $controller->getById($tenant);
});

$router->dispatch();

/*require __DIR__ . '/../vendor/autoload.php';

use SaleHub\Infrastructure\Framework\Router;
use SaleHub\Infrastructure\Framework\Controller\UserController;
use SaleHub\Infrastructure\Framework\Controller\InvoiceController;

$router = new Router();

// Definir rutas y controladores
$router->addRoute('POST', '/users', [new UserController(), 'createUser']);
$router->addRoute('GET', '/invoices', [new InvoiceController(), 'listInvoices']);
// Agrega más rutas según necesites

// Ejecutar el router que aplica middlewares y llama al controlador
$router->dispatch();
*/

/*
require __DIR__ . '/../vendor/autoload.php';


var_dump(class_exists('SaleHub\Infrastructure\ConnectionPool\CustomConnectionPool'));

use SaleHub\Infrastructure\Framework\Router;

// Simulación: obtener tenant del header o subdominio
$tenantIdentifier = $_SERVER['HTTP_X_TENANT'] ?? 'sports';

$router = new Router($tenantIdentifier);
$router->handleRequest();*/
