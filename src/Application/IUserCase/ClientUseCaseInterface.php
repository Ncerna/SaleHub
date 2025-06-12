<?php
namespace App\Application\IUseCase;

use App\Application\Command\CreateClientCommand;
use App\Application\Command\UpdateClientCommand;

interface ClientUseCaseInterface
{
    public function create(CreateClientCommand $command): void;
    public function get(string $id): array;
    public function update(string $id, UpdateClientCommand $command): void;
    public function delete(string $id): void;
    public function list(int $page, int $size): array;
}
