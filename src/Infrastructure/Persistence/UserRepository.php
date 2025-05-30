<?php
namespace App\Infrastructure\Persistence;

use App\Domain\IRepository\IUserRepository;
use App\Domain\Entity\User;
use App\Domain\ValueObject\Email;
use App\Infrastructure\ConnectionPool\CustomConnectionPool;
 
use Exception;

class UserRepository implements IUserRepository {
    private $connection;

    public function __construct(string $tenantIdentifier) {
        $connObj = CustomConnectionPool::getConnection($tenantIdentifier);
        $this->connection = $connObj;
    }

    public function create(User $user): bool {
        $stmt = $this->connection->prepare("INSERT INTO users (id, name, email) VALUES (?, ?, ?)");
        if (!$stmt) {
            throw new Exception("Error preparando la consulta: " . $this->connection->error);
        }

        $id = $user->getId();
        $name = $user->getName();
        $email = (string)$user->getEmail();

        $stmt->bind_param("sss", $id, $name, $email);

        $result = $stmt->execute();
        $stmt->close();

        return $result;
    }

    public function findByEmail(string $email): ?User {
        $stmt = $this->connection->prepare("SELECT id, name, email FROM users WHERE email = ?");
        if (!$stmt) {
            throw new Exception("Error preparando la consulta: " . $this->connection->error);
        }

        $stmt->bind_param("s", $email);
        $stmt->execute();

        $result = $stmt->get_result();
        $userData = $result->fetch_assoc();
        $stmt->close();

        if ($userData) {
            return new User($userData['id'], $userData['name'], new Email($userData['email']));
        }

        return null;
    }
}
