<?php
namespace App\Infrastructure\Persistence;

use App\Domain\Entity\Product;
use App\Domain\IRepository\IProductRepository;
use mysqli;

class ProductRepository implements IProductRepository
{
    private mysqli $connection;

    public function __construct(string $tenant)
    {
        // Aquí obtienes la conexión a BD según el tenant
        $this->connection = ConnectionPool::getConnection($tenant);
    }

    public function create(Product $product): bool
    {
        $stmt = $this->connection->prepare(
            "INSERT INTO products (name, code, price, description) VALUES (?, ?, ?, ?)"
        );
        $stmt->bind_param(
            "ssds",
            $product->getName(),
            $product->getCode(),
            $product->getPrice(),
            $product->getDescription()
        );
        $result = $stmt->execute();
        $stmt->close();
        return $result;
    }

    public function update(Product $product): bool
    {
        $stmt = $this->connection->prepare(
            "UPDATE products SET name = ?, code = ?, price = ?, description = ? WHERE id = ?"
        );
        $stmt->bind_param(
            "ssdsi",
            $product->getName(),
            $product->getCode(),
            $product->getPrice(),
            $product->getDescription(),
            $product->getId()
        );
        $result = $stmt->execute();
        $stmt->close();
        return $result;
    }

    public function delete(string $id): bool
    {
        $stmt = $this->connection->prepare("DELETE FROM products WHERE id = ?");
        $stmt->bind_param("i", $id);
        $result = $stmt->execute();
        $stmt->close();
        return $result;
    }

    public function findById(string $id): ?Product
    {
        $stmt = $this->connection->prepare("SELECT id, name, code, price, description FROM products WHERE id = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $stmt->bind_result($id, $name, $code, $price, $description);
        if ($stmt->fetch()) {
            $product = new Product($id, $name, $code, $price, $description);
            $stmt->close();
            return $product;
        }
        $stmt->close();
        return null;
    }

    public function findAll(int $page, int $size): array
    {
        $offset = ($page - 1) * $size;
        $stmt = $this->connection->prepare("SELECT id, name, code, price, description FROM products LIMIT ?, ?");
        $stmt->bind_param("ii", $offset, $size);
        $stmt->execute();
        $result = $stmt->get_result();

        $products = [];
        while ($row = $result->fetch_assoc()) {
            $products[] = new Product(
                $row['id'],
                $row['name'],
                $row['code'],
                $row['price'],
                $row['description']
            );
        }
        $stmt->close();
        return $products;
    }
}
