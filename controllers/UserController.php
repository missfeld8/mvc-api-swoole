<?php

class UserController
{
    private $userModel;

    public function __construct(UserModel $userModel)
    {
        $this->userModel = $userModel;
    }

    public function createUser(Swoole\Http\Request $request, Swoole\Http\Response $response)
    {
        try {
            $data = $request->post;

            $requiredFields = ['email', 'password'];
            if (array_diff($requiredFields, array_keys($data)) === []) {
                if (array_filter($data) === $data) {
                    $result = $this->userModel->createUser($data);

                    if ($result) {
                        $response->header('Content-Type', 'application/json; charset=utf-8');
                        $response->write(json_encode(['status' => 201, 'message' => 'Usuário criado com sucesso']));
                    } else {
                        $response->status(500);
                        $response->write(json_encode(['status' => 500, 'message' => 'Erro ao criar o usuário']));
                    }
                } else {
                    $response->status(400);
                    $response->write(json_encode(['status' => 400, 'message' => 'Os valores não podem estar vazios']));
                }
            } else {
                $response->status(400);
                $response->write(json_encode(['status' => 400, 'message' => 'Parâmetros inválidos']));
            }
        } catch (PDOException $e) {
            $response->status(500);
            $response->header('Content-Type', 'application/json');
            $response->write(json_encode(['status' => 500, 'message' => 'Erro no banco de dados: ' . $e->getMessage()]));
        } finally {
            $response->end();
        }
    }

    public function verifyUser(Swoole\Http\Request $request, Swoole\Http\Response $response)
    {
        try {
            $data = $request->post;

            $requiredFields = ['email', 'password'];
            if (array_diff($requiredFields, array_keys($data)) === []) {
                $result = $this->userModel->verifyUser($data);

                if ($result) {
                    $response->header('Content-Type', 'application/json; charset=utf-8');
                    $response->write(json_encode(['status' => 200, 'message' => 'Usuário autenticado com sucesso']));
                } else {
                    $response->status(401);
                    $response->write(json_encode(['status' => 401, 'message' => 'Credenciais inválidas']));
                }
            } else {
                $response->status(400);
                $response->write(json_encode(['status' => 400, 'message' => 'Parâmetros inválidos']));
            }
        } catch (PDOException $e) {
            $response->status(500);
            $response->header('Content-Type', 'application/json');
            $response->write(json_encode(['status' => 500, 'message' => 'Erro no banco de dados: ' . $e->getMessage()]));
        } finally {
            $response->end();
        }
    }
}
