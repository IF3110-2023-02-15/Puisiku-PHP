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

        // If the user is logged in and tries to access the home, user, or register routes, redirect them to the dashboard
        if ($role !== null && in_array($path, ['', 'login', 'register'])) {
            header('Location: /home');
            exit();
        }

        foreach ($this->routes as $routePath => $routeData) {
            if (strpos($routePath, ':') !== false) {
                // Convert the route to a regular expression
                $pattern = preg_replace('#:([\w]+)#', '(?P<$1>[\w-]+)', $routePath);
                $pattern = '#^' . $pattern . '$#';

                // If the pattern matches, return the controller and method
                if (preg_match($pattern, $path, $matches)) {
                    // Store the dynamic parameters in $_GET
                    foreach ($matches as $key => $match) {
                        // echo "keyy";
                        // var_dump($key);
                        // var_dump(is_string($key));
                        // echo "match";
                        // var_dump($match);
                        if (is_string($key)) {
                            // echo 'masukkkkkkk';
                            // echo $key, $match;
                            $_GET[$key] = $match;
                        }
                    }


                    $routeSegments = explode('/', $routePath);
                    // echo 'routeap';
                    // var_dump($routeSegments);

                    $method = isset($routeSegments[1]) ? $routeSegments[1] : 'index';
                    // var_dump($method);
            

                    // Check if the necessary keys exist in $routeData before accessing them
                    if (isset($routeData['controller']) && isset($routeData['roles'])) {
                        if (empty($routeData['roles']) || in_array($role, $routeData['roles'])) {
                            // var_dump([$routeData['controller'], 'index']);
                            return [$routeData['controller'], $method];
                        } else {
                            return ['errors', 'index'];
                        }
                    } else {
                        return ['errors', 'index'];
                    }
                }
            }
        }

        // Split the path into controller and method
        $parts = explode('/', $path);
        $controller = $parts[0];
        $method = isset($parts[1]) ? $parts[1] : 'index';

        // Check for static routes
        if (array_key_exists($controller, $this->routes)) {
            if (empty($this->routes[$controller]['roles']) || in_array($role, $this->routes[$controller]['roles'])) {
                return [$this->routes[$controller]['controller'], $method];
            } else {
                return ['errors', 'index'];
            }
        }

        return ['errors', 'index'];
    }
}