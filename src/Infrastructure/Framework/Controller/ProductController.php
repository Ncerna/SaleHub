<?php
namespace App\Infrastructure\Framework\Controller;

use Psr\Http\Message\ServerRequestInterface;
use APP\Application\IUseCase\ProductUseCaseInterface;
use App\Infrastructure\Framework\Adapters\ResponseAdapterInterface;

final class ProductController
{
    private ProductUseCaseInterface $productUseCase;
    private ResponseAdapterInterface $responseAdapter;

    public function __construct(
        ProductUseCaseInterface $productUseCase,
        ResponseAdapterInterface $responseAdapter
    ) {
        $this->productUseCase = $productUseCase;
        $this->responseAdapter = $responseAdapter;
    }

    public function create(ServerRequestInterface $request)
    {
        try {
            $data = (array) $request->getParsedBody();

            // Aquí construimos el comando para crear producto
            $command = new CreateProductCommand($data);

            // Ejecutamos el caso de uso
            $this->productUseCase->create($command);

            return $this->responseAdapter->sendSuccess('Producto creado correctamente.');
        } catch (\Exception $e) {
            return $this->responseAdapter->sendError('Error creando producto: ' . $e->getMessage());
        }
    }

    public function get(ServerRequestInterface $request, string $id)
    {
        try {
            $productData = $this->productUseCase->get($id);

            return $this->responseAdapter->sendSuccess('Producto obtenido.', $productData);
        } catch (\Exception $e) {
            return $this->responseAdapter->sendError('Error obteniendo producto: ' . $e->getMessage());
        }
    }

    public function update(ServerRequestInterface $request, string $id)
    {
        try {
            $data = (array) $request->getParsedBody();

            $command = new UpdateProductCommand($id, $data);

            $this->productUseCase->update($id, $command);

            return $this->responseAdapter->sendSuccess('Producto actualizado correctamente.');
        } catch (\Exception $e) {
            return $this->responseAdapter->sendError('Error actualizando producto: ' . $e->getMessage());
        }
    }

    public function delete(string $id)
    {
        try {
            $this->productUseCase->delete($id);

            return $this->responseAdapter->sendSuccess('Producto eliminado correctamente.');
        } catch (\Exception $e) {
            return $this->responseAdapter->sendError('Error eliminando producto: ' . $e->getMessage());
        }
    }

    public function list(ServerRequestInterface $request)
    {
        try {
            $queryParams = $request->getQueryParams();
            $page = isset($queryParams['page']) ? (int)$queryParams['page'] : 1;
            $size = isset($queryParams['size']) ? (int)$queryParams['size'] : 10;

            $products = $this->productUseCase->list($page, $size);

            return $this->responseAdapter->sendSuccess('Lista de productos obtenida.', $products);
        } catch (\Exception $e) {
            return $this->responseAdapter->sendError('Error listando productos: ' . $e->getMessage());
        }
    }
}
