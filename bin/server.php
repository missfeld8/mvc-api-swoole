<?php

!defined('BASE_PATH') && define('BASE_PATH', dirname(__DIR__, 1));

require BASE_PATH . '/vendor/autoload.php';
$dotenv = Dotenv\Dotenv::createImmutable(BASE_PATH);
$dotenv->load();

use Root\MvcApi\Config\Routes;
use Swoole\Http\Server;
use Swoole\Http\Request;
use Swoole\Http\Response;


$server = new Server("0.0.0.0", 9504);



$server->on("start", function (Server $server) {
    echo "Server is started at http://localhost:9504\n";
});
$routes = new Routes();
$router = $routes->getRoutes();

$server->on("request", function (Request $request, Response $response) use ($router) {
    try {
        $router->resolve($request, $response);
    } catch (Exception $e) {
        $response->status(500);
        $response->end("Server Error: " . $e->getMessage());
    }
});

$server->start();
