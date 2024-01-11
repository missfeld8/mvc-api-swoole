<?php

namespace Root\MvcApi\Controller;

use Swoole\Http\Request;
use Swoole\Http\Response;
use Exception;
use PDOException;
use Root\MvcApi\DTO\UserDTO;
use Root\MvcApi\Model\User;
use Root\MvcApi\Repository\UserRepository;
use Root\MvcApi\Request\CreateUserRequest;

class UserController
{
    private $userDAO;

    public function __construct()
    {
        $this->userDAO = new UserDAO;
    }

    public function createUser(Request $request, Response $response)
    {
        $request = new CreateUserRequest($request);
        $data = $request->getRequest()->post;
        $response->header('Content-Type', 'application/json; charset=utf-8');
        if (!$request->validate($data, $request->rules())) {
            $response->status(400);
            $response->write(json_encode(['status' => 400, 'message' => 'Parâmetros inválidos']));
            $response->end();
            return $response;
        }
        $userDto = new UserDTO(new User);

        $user = $userDto->createUser($data);

        $userRepository = new UserRepository;

        try {
            if (!$userRepository->verifyUser($user)) {
                $response->status(400);
                $response->write(json_encode(['status' => 400, 'message' => 'Usuário ja cadastrado']));
                $response->end();
                return $response;
            }
            $userRepository->insertUser($user);
        } catch (PDOException $e) {
            $response->status(500);
            $response->write(json_encode(['status' => 500, 'message' => 'Erro no banco de dados: ' . $e->getMessage()]));
        } catch (Exception $e) {
            $response->status(500);
            $response->write(json_encode(['status' => 500, 'message' => 'Erro PHP: ' . $e->getMessage()]));
        }
        $response->end();
        return $response;
    }
}
