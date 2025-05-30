<?php
namespace App\Infrastructure\Framework\Factories;

use App\Infrastructure\Persistence\UserRepository;
use App\Infrastructure\ApiClients\ExternalEmailVerificationClient;
use App\Infrastructure\ServiceImplementations\UserService;
use App\Application\Service\UserAppService;

class ServiceFactory {
    public static function createUserAppService(string $tenantIdentifier): UserAppService {
        $userRepository = new UserRepository($tenantIdentifier);
        $emailClient = new ExternalEmailVerificationClient();
        $userService = new UserService($emailClient);
        // Aquí podrías pasar userService a UserAppService si se extiende para validación
        return new UserAppService($userRepository);
    }
}
