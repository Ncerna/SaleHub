<?php
namespace App\Application\IUseCase;
interface ProductUseCaseInterface
{
    public function create(array $data): void;
    public function update(int $id, array $data): void;
    public function delete(int $id): void;
    public function get(int $id): array;
    public function list(): array;
}
