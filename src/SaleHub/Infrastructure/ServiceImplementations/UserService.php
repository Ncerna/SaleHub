<?php
namespace SaleHub\Infrastructure\ServiceImplementations;

use SaleHub\Domain\Entity\User;
use SaleHub\Domain\IService\IUserService;
use SaleHub\Infrastructure\ApiClients\ExternalEmailVerificationClient;

class UserService implements IUserService {
    private ExternalEmailVerificationClient $emailClient;

    public function __construct(ExternalEmailVerificationClient $emailClient) {
        $this->emailClient = $emailClient;
    }

    public function validateUser(User $user): bool {
        // Validación simple: verifica email con cliente externo
        return $this->emailClient->verifyEmail((string)$user->getEmail());
    }
}
