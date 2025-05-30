<?php
namespace App\Infrastructure\Framework\Adapters;

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
}
