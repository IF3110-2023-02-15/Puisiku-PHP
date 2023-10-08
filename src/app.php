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
            'admin' => ['admin', ['admin']],
            'admin/addUser' => ['admin', ['admin']],
            'admin/addPoem' => ['admin', ['admin']],
            'admin/addPlaylist' => ['admin', ['admin']],
            'admin/deleteUser/:id' => ['admin', ['admin']],
            'admin/deletePoem/:id' => ['admin', ['admin']],
            'admin/deletePlaylist/:id' => ['admin', ['admin']],
            'admin/updateUser/:id' => ['admin', ['admin']],
            'admin/updateUserwithRole/:id' => ['admin', ['admin']],
            'admin/updatePoem/:id' => ['admin', ['admin']],
            'admin/updatePlaylist/:id' => ['admin', ['admin']],
            'admin/getUserData/:id' => ['admin', ['admin']],
            'admin/getPlaylistData/:id' => ['admin', ['admin']],
            'logout' => ['logout', $logged_in_role],
            'profile' => ['profile', $logged_in_role],
            'upload' => ['file', $logged_in_role],
            'poems' => ['poems', $logged_in_role],
            'search' => ['search', $logged_in_role],
            'poem/:id' => ['poem', $logged_in_role],
            'playlist' => ['playlist', $logged_in_role],
            'playlist/:id' => ['playlist', $logged_in_role],
            'playlistItem' => ['playlistItem', $logged_in_role],
            'file' => ['file', $logged_in_role],
            'creator' => ['creator', ['admin', 'creator']],
            'creator/getPoemData/:id' => ['creator', ['admin', 'creator']],
            'creator/addPoem' => ['creator', ['admin', 'creator']],
            'creator/getPoems' => ['creator', ['admin', 'creator']],
            'creator/deletePoem/:id' => ['creator', ['admin', 'creator']],
            'creator/updatePoem/:id' => ['creator', ['admin', 'creator']],
            'profile/upgrade' => ['profile', ['user']],
        ]);
    }

    private function handleRequest() {
        // Get the current URI
        $uri = trim(parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH), '/');

        // Get the role of the current user
        $middleware = new Middleware();
        $role = $middleware->getRole();

        try {
            $routeData = $this->router->direct($uri, $role);

            if ($routeData) {
                $controllerName = $routeData['controller'];
                $methodName = $routeData['method'];
                $params = $routeData['params'];

                // Include the appropriate controller file
                require CONTROLLER_DIR . $controllerName . '_controller.php';

                // Instantiate the controller class and call the appropriate method
                $controllerClass = ucfirst($controllerName);
                $controller = new $controllerClass();
                $controller->$methodName($params); // Pass the params to the method

            } else {
                // Handle the case where no matching route is found
                require CONTROLLER_DIR . 'errors_controller.php';
                $errorsController = new Errors();
                $errorsController->index();
            }
        } catch (Exception $e){
            require CONTROLLER_DIR . 'errors_controller.php';
            $errorsController = new Errors();
            $errorsController->index();
        }
    }
}
