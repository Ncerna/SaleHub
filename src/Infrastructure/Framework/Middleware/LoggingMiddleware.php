<?php
// src/Infrastructure/Framework/Middleware/LoggingMiddleware.php

namespace Infrastructure\Framework\Middleware;

class LoggingMiddleware
{
    public function handle(array $serverHeaders, callable $next)
    {
        // Ejemplo simple: registrar la petición
        $method = $_SERVER['REQUEST_METHOD'] ?? 'UNKNOWN';
        $uri = $_SERVER['REQUEST_URI'] ?? 'UNKNOWN';
        $time = date('Y-m-d H:i:s');

        // Aquí podrías usar un logger real o escribir a un archivo
        error_log("[$time] Petición: $method $uri");

        // Continuar con la siguiente función en la cadena
        $next();
    }
}
