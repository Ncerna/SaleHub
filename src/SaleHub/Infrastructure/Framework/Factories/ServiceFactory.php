<?php
namespace SaleHub\Infrastructure\Framework\Factories;

use SaleHub\Infrastructure\Persistence\UserRepository;
use SaleHub\Infrastructure\ApiClients\ExternalEmailVerificationClient;
use SaleHub\Infrastructure\ServiceImplementations\UserService;
use SaleHub\Application\Service\UserAppService;

class ServiceFactory {
    public static function createUserAppService(string $tenantIdentifier): UserAppService {
        $userRepository = new UserRepository($tenantIdentifier);
        $emailClient = new ExternalEmailVerificationClient();
        $userService = new UserService($emailClient);
        // Aquí podrías pasar userService a UserAppService si se extiende para validación
        return new UserAppService($userRepository);
    }
}
