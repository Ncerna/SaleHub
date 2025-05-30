<?php
class ProductUseCase implements ProductUseCaseInterface
{
    public function __construct(
        private CreateProductUseCaseInterface $create,
        private UpdateProductUseCaseInterface $update,
        private DeleteProductUseCaseInterface $delete,
        private GetProductUseCaseInterface $get,
        private ListProductsUseCaseInterface $list
    ) {}

    public function create(array $data): void
    {
        $this->create->execute($data);
    }

    public function update(int $id, array $data): void
    {
        $this->update->execute($id, $data);
    }

    public function delete(int $id): void
    {
        $this->delete->execute($id);
    }

    public function get(int $id): array
    {
        return $this->get->execute($id);
    }

    public function list(): array
    {
        return $this->list->execute();
    }
}
