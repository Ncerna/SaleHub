<?php
namespace App\Domain\IRepository;

use App\Domain\Entity\User;

interface IUserRepository {
    public function create(User $user): bool;
    public function findByEmail(string $email): ?User;
}
