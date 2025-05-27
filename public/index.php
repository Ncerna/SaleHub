<?php
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

require_once __DIR__ . '/../vendor/autoload.php';

use SaleHub\Infrastructure\Framework\Router;

// Simulación: obtener tenant del header o subdominio
$tenantIdentifier = $_SERVER['HTTP_X_TENANT'] ?? 'tenant1_db';

$router = new Router($tenantIdentifier);
$router->handleRequest();
