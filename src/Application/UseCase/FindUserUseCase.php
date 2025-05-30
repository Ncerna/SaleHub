<?php
namespace App\Application\UseCase;

use App\Application\Service\UserAppService;
use App\Domain\Entity\User;

class FindUserUseCase {
    private UserAppService $userAppService;

    public function __construct(UserAppService $userAppService) {
        $this->userAppService = $userAppService;
    }

    public function execute(string $email): ?User {
        return $this->userAppService->findUserByEmail($email);
    }
}
