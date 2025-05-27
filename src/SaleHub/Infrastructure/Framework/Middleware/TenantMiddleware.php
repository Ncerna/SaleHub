<?php
// src/Infrastructure/Framework/Middleware/TenantMiddleware.php
/*
namespace Infrastructure\Framework\Middleware;

class TenantMiddleware
{
    private array $validTenants = ['tenant_123', 'tenant_456']; // Ejemplo de tenants válidos

    public function handle(array $serverHeaders, callable $next)
    {
        $tenantId = $serverHeaders['HTTP_TENANT_ID'] ?? null;

        if (!$tenantId || !in_array($tenantId, $this->validTenants, true)) {
            http_response_code(403);
            echo json_encode(['error' => 'Tenant inválido o no proporcionado']);
            exit;
        }

        // Opcional: establecer contexto global o inyectar tenant en request

        $next();
    }*/

  
    namespace SaleHub\Infrastructure\Framework\Middleware;
    
    class TenantMiddleware
    {
        private array $validTenants;
    
        public function __construct(array $validTenants)
        {
            $this->validTenants = $validTenants;
        }
    
        public function handle(array $serverHeaders, callable $next): void
        {
            $host = $serverHeaders['HTTP_HOST'] ?? '';
            $tenant = explode('.', $host)[0] ?? null;
    
            if (!$tenant || !in_array($tenant, $this->validTenants, true)) {
                http_response_code(403);
                echo json_encode(['error' => 'Tenant inválido']);
                exit;
            }
    
            define('CURRENT_TENANT', $tenant);
    
            $next();
        }
    }
    
