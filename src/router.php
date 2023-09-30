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
        // Parse the URI and separate the path and query string
        $parsedUrl = parse_url($uri);
        $path = trim($parsedUrl['path'], '/');
        $queryString = isset($parsedUrl['query']) ? $parsedUrl['query'] : '';

        // If the user is logged in and tries to access the home, user, or register routes, redirect them to the dashboard
        if ($role !== null && in_array($path, ['', 'login', 'register'])) {
            header('Location: /home');
            exit();
        }

        // Check for dynamic routes
        foreach ($this->routes as $routePath => $routeData) {
            if (strpos($routePath, ':') !== false) {
                // Convert the route to a regular expression
                $pattern = preg_replace('#:([\w]+)#', '(?P<$1>[\w-]+)', $routePath);
                $pattern = '#^' . $pattern . '$#';

                // If the pattern matches, return the controller
                if (preg_match($pattern, $path, $matches)) {
                    // Store the dynamic parameters in $_GET
                    foreach ($matches as $key => $match) {
                        if (is_string($key)) {
                            $_GET[$key] = $match;
                        }
                    }

                    return $routeData['controller'];
                }
            }
        }

        // Check for static routes
        if (array_key_exists($path, $this->routes)) {
            if (empty($this->routes[$path]['roles']) || in_array($role, $this->routes[$path]['roles'])) {
                // Parse the query string and store it in $_GET
                parse_str($queryString, $_GET);

                return $this->routes[$path]['controller'];
            } else {
                return 'errors';
            }
        }

        return 'errors';
    }
}
