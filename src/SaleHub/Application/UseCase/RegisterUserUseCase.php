<?php
namespace SaleHub\Application\UseCase;

use SaleHub\Application\Service\UserAppService;
use SaleHub\Domain\ValueObject\Email;
use Exception;

class RegisterUserUseCase {
    private UserAppService $userAppService;

    public function __construct(UserAppService $userAppService) {
        $this->userAppService = $userAppService;
    }

    public function execute(string $id, string $name, string $email): void {
        $existingUser = $this->userAppService->findUserByEmail($email);
        if ($existingUser !== null) {
            throw new Exception("El usuario con email {$email} ya existe.");
        }
        $this->userAppService->registerUser($id, $name, $email);
    }
}
