<?php
/*namespace App\Infrastructure\Framework\Adapters;

class JsonResponseAdapter {
    public function sendSuccess(string $message): void {
        http_response_code(200);
        echo json_encode(['status' => 'success', 'message' => $message]);
    }

    public function sendError(string $message): void {
        http_response_code(400);
        echo json_encode(['status' => 'error', 'message' => $message]);
    }

    public function sendData(array $data): void {
        http_response_code(200);
        echo json_encode(['status' => 'success', 'data' => $data]);
    }
}*/
namespace App\Infrastructure\Framework\Adapters;

class JsonResponseAdapter implements ResponseAdapterInterface
{
    public function sendSuccess(string $message, $data = null, int $statusCode = 200)
    {
        http_response_code($statusCode);
        header('Content-Type: application/json');
        echo json_encode([
            'status' => 'success',
            'message' => $message,
            'data' => $data,
        ]);
        exit;
    }

    public function sendError(string $message, int $statusCode = 400, $errors = null)
    {
        http_response_code($statusCode);
        header('Content-Type: application/json');
        echo json_encode([
            'status' => 'error',
            'message' => $message,
            'errors' => $errors,
        ]);
        exit;
    }
}
