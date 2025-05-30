<?php
namespace SaleHub\Infrastructure\Framework\Controller;
use SaleHub\Application\UseCase\RegisterUserUseCase;
use SaleHub\Application\UseCase\FindUserUseCase;
use SaleHub\Infrastructure\Persistence\UserRepository;
use SaleHub\Infrastructure\ApiClients\ExternalEmailVerificationClient;
use SaleHub\Infrastructure\ServiceImplementations\UserService;
use SaleHub\Application\Service\UserAppService;
use SaleHub\Infrastructure\Framework\Adapters\JsonResponseAdapter;

class UserController {
    private RegisterUserUseCase $registerUserUseCase;
    private FindUserUseCase $findUserUseCase;
    private JsonResponseAdapter $responseAdapter;

    public function __construct(string $tenantIdentifier) {
        $userRepository = new UserRepository($tenantIdentifier);
        $emailClient = new ExternalEmailVerificationClient();
        $userService = new UserService($emailClient);
        $userAppService = new UserAppService($userRepository);

        // Aquí podrías inyectar userService en userAppService si se requiere validación

        $this->registerUserUseCase = new RegisterUserUseCase($userAppService);
        $this->findUserUseCase = new FindUserUseCase($userAppService);
        $this->responseAdapter = new JsonResponseAdapter();
    }

    public function register(array $requestData): void {
        try {
            if (empty($requestData['id']) || empty($requestData['name']) || empty($requestData['email'])) {
                throw new \Exception("Datos incompletos para registro.");
            }

            $this->registerUserUseCase->execute($requestData['id'], $requestData['name'], $requestData['email']);

            $this->responseAdapter->sendSuccess("Usuario registrado correctamente.");
        } catch (\Exception $e) {
            $this->responseAdapter->sendError($e->getMessage());
        }
    }

    public function find(string $email): void {
        try {
            $user = $this->findUserUseCase->execute($email);
            if ($user === null) {
                $this->responseAdapter->sendError("Usuario no encontrado.");
                return;
            }

            $this->responseAdapter->sendData([
                'id' => $user->getId(),
                'name' => $user->getName(),
                'email' => (string)$user->getEmail()
            ]);
        } catch (\Exception $e) {
            $this->responseAdapter->sendError($e->getMessage());
        }
    }
}

