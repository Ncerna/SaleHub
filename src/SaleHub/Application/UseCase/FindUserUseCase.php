<?php
namespace SaleHub\Application\UseCase;

use SaleHub\Application\Service\UserAppService;
use SaleHub\Domain\Entity\User;

class FindUserUseCase {
    private UserAppService $userAppService;

    public function __construct(UserAppService $userAppService) {
        $this->userAppService = $userAppService;
    }

    public function execute(string $email): ?User {
        return $this->userAppService->findUserByEmail($email);
    }
}
