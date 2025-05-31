<?php
require __DIR__ . '/../vendor/autoload.php';
use App\Infrastructure\Framework\Router;
use App\Infrastructure\Framework\Controller\UserController;
use App\Infrastructure\Framework\Controller\InvoiceController;
use App\Infrastructure\Framework\Controller\SalesController;
use GuzzleHttp\Psr7\ServerRequest;
// index.php - API REST simple en PHP puro
// Habilitar CORS para pruebas locales (opcional, pero recomendado)
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type");

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


require_once __DIR__ . '/../vendor/autoload.php';


/*
$request = ServerRequest::fromGlobals();

$router = new Router();
$router->handle($request);*/


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

