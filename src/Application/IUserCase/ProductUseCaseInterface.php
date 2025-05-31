<?php
namespace App\Application\IUseCase;
use App\Application\Command\CreateProductCommand;
use App\Application\Command\UpdateProductCommand;
interface ProductUseCaseInterface
{
    public function create(CreateProductCommand $command): void;
    public function update(int $id, UpdateProductCommand $command): void;
    public function delete(int $id): void;
    public function get(int $id): array;
    public function list(int $page, int $size): array;
}
