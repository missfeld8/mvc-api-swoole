<?php

require __DIR__ . '/vendor/autoload.php';
require __DIR__ . '/config/database.php';
require __DIR__ . '/src/Router.php';
require __DIR__ . '/models/ArticleModel.php';  
require __DIR__ . '/models/UserModel.php';
require __DIR__ . '/controllers/ArticleController.php';
require __DIR__ . '/controllers/UserController.php';


use Swoole\Http\Server;
use Swoole\Http\Request;
use Swoole\Http\Response;

$server = new Server("localhost", 9504);

$router = new Router();

$db = new PDO(
    "mysql:host={$databaseConfig['host']};dbname={$databaseConfig['database']}",
    $databaseConfig['user'],
    $databaseConfig['password']
);

$articleModel = new ArticleModel($db); 
$userModel = new UserModel($db);
$articleController = new ArticleController($articleModel);
$userController = new UserController($userModel);


$router->get('/get', [$articleController, 'getAll']);
$router->get('/find/{id}', [$articleController, 'getById']);
$router->post('/create', [$articleController, 'createArticle']);
$router->post('/update/{id}', [$articleController, 'update']);
$router->post('/delete/{id}', [$articleController, 'delete']);
$router->post('/create-user', [$userController, 'create']);
$router->post('/verify-user', [$userController, 'verify']);

$router->get('/static/{file}', function (Request $request, Response $response) {
    $filename = '';
    if (isset($request->get['file'])) {
        $filename = __DIR__ . '/public/' . $request->get['file'];
    }
    
    if (file_exists($filename)) {
        $response->header('Content-Type', mime_content_type($filename));
        $response->sendfile($filename);
    } else {
        $response->status(404);
        $response->end("Not Found");
    }
}); 

$server->on("start", function (Server $server) {
    echo "OpenSwoole http server is started at http://localhost:9504\n";
});

$server->on("request", function (Request $request, Response $response) use ($router) {
    try {
        $router->resolve($request, $response);
    } catch (Exception $e) {
        $response->status(500);
        $response->end("Server Error: " . $e->getMessage());
    }
});

$server->start();
