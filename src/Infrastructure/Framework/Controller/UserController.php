<?php
namespace App\Infrastructure\Framework\Controller;
use App\Application\UseCase\RegisterUserUseCase;
use App\Application\UseCase\FindUserUseCase;
use App\Infrastructure\Persistence\UserRepository;
use App\Infrastructure\ApiClients\ExternalEmailVerificationClient;
use App\Infrastructure\ServiceImplementations\UserService;
use App\Application\Service\UserAppService;
use App\Infrastructure\Framework\Adapters\JsonResponseAdapter;

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

