<?php
namespace App\Application\UseCase;

use App\Application\Command\CreateClientCommand;
use App\Application\Command\UpdateClientCommand;
use App\Application\IUseCase\ClientUseCaseInterface;
use App\Domain\Repository\ClientRepositoryInterface;

final class ClientUseCase implements ClientUseCaseInterface
{
    private ClientRepositoryInterface $repository;

    public function __construct(ClientRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    public function create(CreateClientCommand $command): void
    {
        $this->repository->save($command->data);
    }

    public function get(string $id): array
    {
        return $this->repository->findById($id);
    }

    public function update(string $id, UpdateClientCommand $command): void
    {
        $this->repository->update($id, $command->data);
    }

    public function delete(string $id): void
    {
        $this->repository->delete($id);
    }

    public function list(int $page, int $size): array
    {
        return $this->repository->findAll($page, $size);
    }
}
