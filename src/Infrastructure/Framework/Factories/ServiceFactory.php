<?php
namespace App\Infrastructure\Framework\Factories;

use App\Infrastructure\Persistence\UserRepository;
use App\Infrastructure\ApiClients\ExternalEmailVerificationClient;
use App\Infrastructure\ServiceImplementations\UserService;
use App\Application\Service\UserAppService;

use App\Infrastructure\Persistence\ProductRepository;
use App\Application\UseCase\ProductUseCase;
use App\Application\UseCase\ProductUseCaseInterface;
use App\Infrastructure\Framework\Adapters\JsonResponseAdapter;
use App\Infrastructure\Framework\Adapters\ResponseAdapterInterface;
use App\Infrastructure\Framework\Controller\ProductController;

class ServiceFactory {
    public static function createUserAppService(string $tenantIdentifier): UserAppService {
        $userRepository = new UserRepository($tenantIdentifier);
        $emailClient = new ExternalEmailVerificationClient();
        $userService = new UserService($emailClient);
        // Aquí podrías pasar userService a UserAppService si se extiende para validación
        return new UserAppService($userRepository);
    }
    /**
     * Crea la instancia del ProductController con todas sus dependencias.
     *
     * @param string $tenant Identificador del tenant para conexión.
     * @return ProductController
     */
    public static function createProductController(string $tenant): ProductController
    {
        // Repositorio concreto que implementa IProductRepository
        $productRepository = new ProductRepository($tenant);

        // Caso de uso que implementa ProductUseCaseInterface
        $productUseCase = new ProductUseCase($productRepository);

        // Adaptador para respuestas (JSON, por ejemplo)
        $responseAdapter = new JsonResponseAdapter();

        // Crear y devolver controlador con inyección de dependencias
        return new ProductController($productUseCase, $responseAdapter);
    }
    public static function createClientController(string $tenant): ClientController
{
    $clientRepository = new ClientRepository($tenant);
    $clientUseCase = new ClientUseCase($clientRepository);
    $responseAdapter = new JsonResponseAdapter();

    return new ClientController($clientUseCase, $responseAdapter);
}

}
