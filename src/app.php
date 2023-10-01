<?php

require_once SRC_DIR . 'router.php';
require_once SRC_DIR . 'middlewares/auth.php';

class App {
    private $router;

    public function __construct() {
        $this->router = new Router();
        $this->defineRoutes();
        $this->handleRequest();
    }

    private function defineRoutes() {
        $logged_in_role = ['user', 'admin', 'creator'];

        // Define routes
        $this->router->define([
            '' => ['landing'],
            'login' => ['login'],
            'register' => ['register'],
            'home' => ['home', $logged_in_role],
            'logout' => ['logout', $logged_in_role],
            'upload' => ['file', $logged_in_role],
            'poems' => ['poems', $logged_in_role],
            'search' => ['search', $logged_in_role]
//            'playlist/:id' => ['playlist', ['user', 'admin', 'creator']]
        ]);
    }

    private function handleRequest() {
        // Get the current URI
        $uri = trim(parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH), '/');

        // Get the role of the current user
        $middleware = new Middleware();
        $role = $middleware->getRole();

        // Direct the request to the appropriate controller and method
        list($controllerName, $methodName) = $this->router->direct($uri, $role);

        require CONTROLLER_DIR . $controllerName . '_controller.php';

        // Instantiate the controller class and call the appropriate method
        $controllerClass = ucfirst($controllerName);
        $controller = new $controllerClass();
        $controller->$methodName();
    }
}

