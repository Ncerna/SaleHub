<?php
namespace App\Infrastructure\Framework\Controller;

class SalesController
{
    private static $sales = []; // Simulamos base de datos en memoria

    public function save(string $tenant)
    {
        $input = json_decode(file_get_contents('php://input'), true);
        if (!$input) {
            http_response_code(400);
            echo json_encode(['error' => 'Datos inválidos']);
            return;
        }

        $sale = [
            'id' => count(self::$sales) + 1,
            'product' => $input['product'] ?? 'Producto sin nombre',
            'quantity' => $input['quantity'] ?? 1,
            'tenant' => $tenant,
        ];
        self::$sales[] = $sale;

        header('Content-Type: application/json');
        echo json_encode([
            'message' => "Venta guardada para tenant: $tenant",
            'sale' => $sale
        ]);
    }

    public function list(string $tenant)
    {
        $filteredSales = array_filter(self::$sales, function($sale) use ($tenant) {
            return $sale['tenant'] === $tenant;
        });

        header('Content-Type: application/json');
        echo json_encode(array_values($filteredSales));
    }

    public function getById(string $tenant)
    {
        $id = $_GET['id'] ?? null;
        if (!$id) {
            http_response_code(400);
            echo json_encode(['error' => 'ID requerido']);
            return;
        }

        $foundSale = null;
        foreach (self::$sales as $sale) {
            if ($sale['id'] == $id && $sale['tenant'] === $tenant) {
                $foundSale = $sale;
                break;
            }
        }

        if (!$foundSale) {
            http_response_code(404);
            echo json_encode(['error' => 'Venta no encontrada']);
            return;
        }

        header('Content-Type: application/json');
        echo json_encode($foundSale);
    }
}
