<?php

class ArticleController
{
    private $articleModel;

    public function __construct(ArticleModel $articleModel)
    {
        $this->articleModel = $articleModel;
    }

    public function getAll(Swoole\Http\Request $request, Swoole\Http\Response $response)
{
    try {
        $articles = $this->articleModel->getAllArticles();

        $response->header('Content-Type', 'application/json');
        $response->write(json_encode(['status' => 200, 'data' => $articles]));
    } catch (PDOException $e) {
        $response->status(500);
        $response->write(json_encode(['status' => 500, 'message' => 'Erro no banco de dados: ' . $e->getMessage()]));
    } finally {
        $response->end();
    }
}



    public function findArticleById(Swoole\Http\Request $request, Swoole\Http\Response $response, $id)
{
    try {
        $article = $this->articleModel->findArticleById($id);

        if ($article !== false) {
            $response->status(200);
            $response->write(json_encode(['status' => 200, 'data' => $article]));
        } else {
            $response->status(404);
            $response->write(json_encode(['status' => 404, 'message' => 'Registro não encontrado']));
        }
    } catch (PDOException $e) {
        $response->status(500);
        $response->write(json_encode(['status' => 500, 'message' => 'Erro no banco de dados: ' . $e->getMessage()]));
    } finally {
        $response->end();
    }
}

public function createArticle(Swoole\Http\Request $request, Swoole\Http\Response $response)
{
    try {
        $data = $request->post;

        $requiredFields = ['name', 'article_body', 'author', 'author_avatar'];
        if (array_diff($requiredFields, array_keys($data)) === []) {
            if (array_filter($data) === $data) {
                $result = $this->articleModel->createArticle($data);

                if ($result) {
                    $response->header('Content-Type', 'application/json; charset=utf-8');
                    $response->write(json_encode(['status' => 201, 'message' => 'Registro criado com sucesso']));
                } else {
                    $response->status(500);
                    $response->write(json_encode(['status' => 500, 'message' => 'Erro ao criar o registro']));
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


public function updateArticle(Swoole\Http\Request $request, Swoole\Http\Response $response, $id)
{
    try {
        $data = json_decode($request->rawContent(), true);

        if ($data === null && json_last_error() !== JSON_ERROR_NONE) {
            throw new Exception('Erro na decodificação JSON: ' . json_last_error_msg());
        }

        $requiredFields = ['name', 'article_body', 'author', 'author_avatar'];
        if (array_diff($requiredFields, array_keys($data)) === []) {
            $checkExistenceQuery = $this->articleModel->findArticleById($id);

            if ($checkExistenceQuery) {
                $result = $this->articleModel->updateArticle($id, $data);

                if ($result) {
                    $response->json(['status' => 200, 'message' => 'Registro atualizado com sucesso']);
                } else {
                    $response->status(500);
                    $response->json(['status' => 500, 'message' => 'Erro ao atualizar o registro']);
                }
            } else {
                $response->status(404);
                $response->json(['status' => 404, 'message' => 'Registro não encontrado']);
            }
        } else {
            $response->status(400);
            $response->json(['status' => 400, 'message' => 'Parâmetros inválidos']);
        }
    } catch (PDOException $e) {
        $response->status(500);
        $response->json(['status' => 500, 'message' => 'Erro no banco de dados: ' . $e->getMessage()]);
    } catch (Exception $e) {
        $response->status(400);
        $response->json(['status' => 400, 'message' => 'Erro na solicitação: ' . $e->getMessage()]);
    } finally {
        $response->end();
    }
}

public function deleteArticle(Swoole\Http\Request $request, Swoole\Http\Response $response, $id)
{
    try {
        $checkExistenceQuery = $this->articleModel->findArticleById($id);

        if ($checkExistenceQuery) {
            $result = $this->articleModel->deleteArticle($id);

            if ($result) {
                $response->header('Content-Type', 'application/json');
                $response->write(json_encode(['status' => 200, 'message' => 'Registro excluído com sucesso']));
            } else {
                $response->status(500);
                $response->write(json_encode(['status' => 500, 'message' => 'Erro ao excluir o registro']));
            }
        } else {
            $response->status(404);
            $response->header('Content-Type', 'application/json');
            $response->write(json_encode(['status' => 404, 'message' => 'Registro não encontrado']));
        }
    } catch (PDOException $e) {
        $response->status(500);
        $response->write("Erro no banco de dados: " . $e->getMessage());
    } finally {
        $response->end();
    }
}

}