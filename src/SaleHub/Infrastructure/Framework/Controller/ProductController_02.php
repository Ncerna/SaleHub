<?php
class ProductController
{
    public function __construct(
        private ProductUseCaseInterface $productUseCase,
        private JsonResponseAdapterInterface $responseAdapter
    ) {}

    public function create(array $data): void
    {
        $this->productUseCase->create($data);
        $this->responseAdapter->success('Producto creado');
    }

    public function update(int $id, array $data): void
    {
        $this->productUseCase->update($id, $data);
        $this->responseAdapter->success('Producto actualizado');
    }

    public function delete(int $id): void
    {
        $this->productUseCase->delete($id);
        $this->responseAdapter->success('Producto eliminado');
    }

    public function get(int $id): void
    {
        $product = $this->productUseCase->get($id);
        $this->responseAdapter->json($product);
    }

    public function list(): void
    {
        $products = $this->productUseCase->list();
        $this->responseAdapter->json($products);
    }
}
