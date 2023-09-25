<?php

require_once SRC_DIR . 'router.php';
require_once VIEWS_DIR . 'components/notification.php';

class App {
    private $router;

    public function __construct() {
        $this->router = new Router();
        $this->defineRoutes();
        $this->handleRequest();
    }

    private function defineRoutes() {
        // Define routes
        $this->router->define([
            '' => 'home',
            'login' => 'login',
            'register' => 'register',
            'dashboard' => 'dashboard',
        ]);
    }

    private function handleRequest() {
        // Get the current URI
        $uri = trim(parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH), '/');
        
        // Direct the request to the appropriate controller
        $controllerName = $this->router->direct($uri);

        require CONTROLLER_DIR . $controllerName . '_controller.php';

        // Instantiate the controller class and call the index method
        $controllerClass = ucfirst($controllerName);
        $controller = new $controllerClass();
        $controller->index();
    }
}
