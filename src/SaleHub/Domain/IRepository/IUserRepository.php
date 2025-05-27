<?php
namespace SaleHub\Domain\IRepository;

use SaleHub\Domain\Entity\User;

interface IUserRepository {
    public function create(User $user): bool;
    public function findByEmail(string $email): ?User;
}
