<?php
namespace SaleHub\Infrastructure\ConnectionPool;

use Exception;

class CustomConnectionPool_lwp  {
    private static array $instances = []; // Conexiones por tenant
    private static int $ttl = 600; // Tiempo de vida en segundos (10 minutos)

    /**
     * Obtiene o crea una conexión mysqli para un tenant específico.
     *
     * @param string $tenantIdentifier Identificador del tenant (nombre BD).
     * @return \mysqli Objeto de conexión mysqli.
     * @throws Exception Si la conexión falla.
     */
    public static function getConnection(string $tenantIdentifier): \mysqli {
        $now = time();

        // Limpia conexiones inactivas
        foreach (self::$instances as $tenant => $connData) {
            if ($now - $connData['lastUsed'] > self::$ttl) {
                $connData['connection']->close();
                unset(self::$instances[$tenant]);
            }
        }

        // Si ya existe conexión activa, actualiza lastUsed y devuelve
        if (isset(self::$instances[$tenantIdentifier])) {
            self::$instances[$tenantIdentifier]['lastUsed'] = $now;
            return self::$instances[$tenantIdentifier]['connection'];
        }

        // Crear nueva conexión mysqli para tenant
        $servername = "localhost";
        $username = "root";
        $password = "oracle";
        $database = $tenantIdentifier;

        $mysqli = new \mysqli($servername, $username, $password, $database);

        if ($mysqli->connect_error) {
            throw new Exception("Error de conexión para tenant {$tenantIdentifier}: " . $mysqli->connect_error);
        }

        // Guardar conexión en pool
        self::$instances[$tenantIdentifier] = [
            'connection' => $mysqli,
            'lastUsed' => $now
        ];

        return $mysqli;
    }

    /**
     * Cierra todas las conexiones activas.
     */
    public static function closeAll(): void {
        foreach (self::$instances as $connData) {
            $connData['connection']->close();
        }
        self::$instances = [];
    }

    /**
     * Cambia el TTL (tiempo de vida) para conexiones inactivas.
     *
     * @param int $seconds Tiempo en segundos.
     */
    public static function setTTL(int $seconds): void {
        self::$ttl = $seconds;
    }
}
