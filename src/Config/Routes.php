<?php

namespace Root\MvcApi\Config;
use Root\MvcApi\Controller\UserController; 

class Routes
{

    private Router $router;

    public function __construct()
    {
        $router = new Router();

        //$router->get('/get', ['$articleController', 'getAll']);
       // $router->get('/find/{id}', ['$articleController', 'getById']);
        $router->post('/create', [UserController::class, 'createUser']);
        //$router->post('/update/{id}', ['$articleController', 'update']);
       // $router->post('/delete/{id}', ['$articleController', 'delete']);
       // $router->post('/create-user', ['$userController', 'create']);
       // $router->post('/verify-user', ['$userController', 'verify']);

        $this->router = $router;
    }

    public function getRoutes()
    {
        return $this->router;
    }
}
