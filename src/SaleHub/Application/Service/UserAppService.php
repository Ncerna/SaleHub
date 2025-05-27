<?php
namespace SaleHub\Application\Service;

use SaleHub\Domain\IRepository\IUserRepository;
use SaleHub\Domain\Entity\User;
use SaleHub\Domain\ValueObject\Email;

class UserAppService {
    private IUserRepository $userRepository;

    public function __construct(IUserRepository $userRepository) {
        $this->userRepository = $userRepository;
    }

    public function registerUser(string $id, string $name, string $email): void {
        $user = new User($id, $name, new Email($email));
        $this->userRepository->create($user);
    }

    public function findUserByEmail(string $email): ?User {
        return $this->userRepository->findByEmail($email);
    }
}
