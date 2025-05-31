<?php
namespace App\Infrastructure\Framework\Controller;

use App\Application\IUseCase\ProductUseCaseInterface;
use App\Infrastructure\Framework\Adapters\ResponseAdapterInterface;

class ProductController02
{
    private ProductUseCaseInterface $productUseCase;
    private ResponseAdapterInterface $responseAdapter;

    public function __construct(ProductUseCaseInterface $productUseCase, ResponseAdapterInterface $responseAdapter)
    {
        $this->productUseCase = $productUseCase;
        $this->responseAdapter = $responseAdapter;
    }

    public function create(array $data): void
    {
        try {
            $this->productUseCase->create($data);
            $this->responseAdapter->sendSuccess('Producto creado correctamente.');
        } catch (\Exception $e) {
            $this->responseAdapter->sendError('Error creando producto: ' . $e->getMessage());
        }
    }

    public function get(int $id): void
    {
        try {
            $product = $this->productUseCase->get($id);
            $this->responseAdapter->sendSuccess('Producto obtenido.', $product);
        } catch (\Exception $e) {
            $this->responseAdapter->sendError('Error obteniendo producto: ' . $e->getMessage());
        }
    }

    public function update(int $id, array $data): void
    {
        try {
            $this->productUseCase->update($id, $data);
            $this->responseAdapter->sendSuccess('Producto actualizado correctamente.');
        } catch (\Exception $e) {
            $this->responseAdapter->sendError('Error actualizando producto: ' . $e->getMessage());
        }
    }

    public function delete(int $id): void
    {
        try {
            $this->productUseCase->delete($id);
            $this->responseAdapter->sendSuccess('Producto eliminado correctamente.');
        } catch (\Exception $e) {
            $this->responseAdapter->sendError('Error eliminando producto: ' . $e->getMessage());
        }
    }

    public function list(): void
    {
        try {
            $products = $this->productUseCase->list(1, 100); // ejemplo página 1, 100 items
            $this->responseAdapter->sendSuccess('Lista de productos obtenida.', $products);
        } catch (\Exception $e) {
            $this->responseAdapter->sendError('Error listando productos: ' . $e->getMessage());
        }
    }
}
