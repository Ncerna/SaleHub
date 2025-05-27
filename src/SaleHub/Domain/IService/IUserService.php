<?php
namespace SaleHub\Domain\IService;

use SaleHub\Domain\Entity\User;

interface IUserService {
    public function validateUser(User $user): bool;
}
