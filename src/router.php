<?php

class Router {
    private $routes = [];

    public function define($routes) {
        foreach ($routes as $uri => $data) {
            $this->routes[$uri] = [
                'controller' => $data[0],
                'roles' => isset($data[1]) ? $data[1] : []
            ];
        }
    }

    public function direct($uri, $role) {
        // If the user is logged in and tries to access the home, user, or register routes, redirect them to the homepage
        if ($role !== null && in_array($uri, ['', 'login', 'register'])) {
            header('Location: /home');
            exit();
        }

        if (array_key_exists($uri, $this->routes)) {
            if (empty($this->routes[$uri]['roles']) || in_array($role, $this->routes[$uri]['roles'])) {
                return $this->routes[$uri]['controller'];
            } else {
                return 'errors';
            }
        }

        return 'errors';
    }

}