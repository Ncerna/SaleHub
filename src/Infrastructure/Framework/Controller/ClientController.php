<?php

namespace App\Infrastructure\Framework\Controller;

use Psr\Http\Message\ServerRequestInterface;
use APP\Application\IUseCase\ProductUseCaseInterface;
use App\Infrastructure\Framework\Adapters\ResponseAdapterInterface;
final class ClientController
{
    private ClientUseCaseInterface $clientUseCase;
    private ResponseAdapterInterface $responseAdapter;

    public function __construct(
        ClientUseCaseInterface $clientUseCase,
        ResponseAdapterInterface $responseAdapter
    ) {
        $this->clientUseCase = $clientUseCase;
        $this->responseAdapter = $responseAdapter;
    }

    public function create(ServerRequestInterface $request)
    {
        try {
            $data = (array) $request->getParsedBody();
            $command = new CreateClientCommand($data);
            $this->clientUseCase->create($command);
            return $this->responseAdapter->sendSuccess('Cliente creado correctamente.');
        } catch (\Exception $e) {
            return $this->responseAdapter->sendError('Error creando cliente: ' . $e->getMessage());
        }
    }

    public function get(ServerRequestInterface $request, string $id)
    {
        try {
            $clientData = $this->clientUseCase->get($id);
            return $this->responseAdapter->sendSuccess('Cliente obtenido.', $clientData);
        } catch (\Exception $e) {
            return $this->responseAdapter->sendError('Error obteniendo cliente: ' . $e->getMessage());
        }
    }

    public function update(ServerRequestInterface $request, string $id)
    {
        try {
            $data = (array) $request->getParsedBody();
            $command = new UpdateClientCommand($id, $data);
            $this->clientUseCase->update($id, $command);
            return $this->responseAdapter->sendSuccess('Cliente actualizado correctamente.');
        } catch (\Exception $e) {
            return $this->responseAdapter->sendError('Error actualizando cliente: ' . $e->getMessage());
        }
    }

    public function delete(string $id)
    {
        try {
            $this->clientUseCase->delete($id);
            return $this->responseAdapter->sendSuccess('Cliente eliminado correctamente.');
        } catch (\Exception $e) {
            return $this->responseAdapter->sendError('Error eliminando cliente: ' . $e->getMessage());
        }
    }

    public function list(ServerRequestInterface $request)
    {
        try {
            $queryParams = $request->getQueryParams();
            $page = isset($queryParams['page']) ? (int)$queryParams['page'] : 1;
            $size = isset($queryParams['size']) ? (int)$queryParams['size'] : 10;
            $clients = $this->clientUseCase->list($page, $size);
            return $this->responseAdapter->sendSuccess('Lista de clientes obtenida.', $clients);
        } catch (\Exception $e) {
            return $this->responseAdapter->sendError('Error listando clientes: ' . $e->getMessage());
        }
    }
}
