<?php
namespace App\Infrastructure\Framework\Adapters;

interface ResponseAdapterInterface
{
    /**
     * Envía una respuesta exitosa.
     *
     * @param string $message Mensaje de éxito.
     * @param mixed|null $data Datos adicionales a incluir en la respuesta.
     * @param int $statusCode Código HTTP (por defecto 200).
     * @return mixed Respuesta formateada (por ejemplo, un objeto Response o array).
     */
    public function sendSuccess(string $message, $data = null, int $statusCode = 200);

    /**
     * Envía una respuesta de error.
     *
     * @param string $message Mensaje de error.
     * @param int $statusCode Código HTTP de error (por defecto 400).
     * @param mixed|null $errors Información adicional sobre el error.
     * @return mixed Respuesta formateada.
     */
    public function sendError(string $message, int $statusCode = 400, $errors = null);
}
