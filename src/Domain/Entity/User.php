<?php
namespace App\Domain\Entity;

use App\Domain\ValueObject\Email;

class User {
    private string $id;
    private string $name;
    private Email $email;

    public function __construct(string $id, string $name, Email $email) {
        $this->id = $id;
        $this->name = trim($name);
        $this->email = $email;
    }

    public function getId(): string {
        return $this->id;
    }
    public function getName(): string {
        return $this->name;
    }
    public function getEmail(): Email {
        return $this->email;
    }
}
