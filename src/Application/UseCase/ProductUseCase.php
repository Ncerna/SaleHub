<?php
namespace App\Application\UseCase;

use App\Application\IUseCase\ProductUseCaseInterface;
use App\Domain\IRepository\IProductRepository;
use App\Application\Command\CreateProductCommand;
use App\Application\Command\UpdateProductCommand;
use App\Domain\Entity\Product;

class ProductUseCase implements ProductUseCaseInterface
{
    private IProductRepository $repository;

    public function __construct(IProductRepository $repository)
    {
        $this->repository = $repository;
    }

    public function create(CreateProductCommand $command): void
    {
        // Mapear comando a entidad y validar
        $product = new Product(
            null,
            $command->name,
            $command->code,
            // otros campos...
        );
        $this->repository->create($product);
    }

    public function update(int $id, UpdateProductCommand $command): void
    {
        // Obtener entidad, actualizar campos, validar y persistir
        $product = $this->repository->findById($id);
        if (!$product) {
            throw new \Exception("Producto no encontrado");
        }
        $product->setName($command->name);
        $product->setCode($command->code);
        // otros campos...
        $this->repository->update($product);
    }

    public function delete(int $id): void
    {
        $this->repository->delete($id);
    }

    public function get(int $id): array
    {
        $product = $this->repository->findById($id);
        if (!$product) {
            throw new \Exception("Producto no encontrado");
        }
        // Mapear entidad a array o DTO
        return [
            'id' => $product->getId(),
            'name' => $product->getName(),
            'code' => $product->getCode(),
            // otros campos...
        ];
    }

    public function list(int $page, int $size): array
    {
        $products = $this->repository->findAll($page, $size);
        // Mapear entidades a arrays o DTOs
        return array_map(function($product) {
            return [
                'id' => $product->getId(),
                'name' => $product->getName(),
                'code' => $product->getCode(),
                // otros campos...
            ];
        }, $products);
    }
}
