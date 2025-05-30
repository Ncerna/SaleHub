<?php
namespace App\Domain\IService;

use App\Domain\Entity\User;

interface IUserService {
    public function validateUser(User $user): bool;
}
