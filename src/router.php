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
        if ($role !== null && in_array($path, ['', 'login', 'register']) && !($role === 'admin' && $path === 'register')) {
                header('Location: /poems');
                exit();
        }
    
        foreach ($this->routes as $routePath => $routeData) {
            if (strpos($routePath, ':') !== false) {
                // Convert the route to a regular expression
                $pattern = preg_replace('#:([\w]+)#', '(?P<$1>[\w-]+)', $routePath);
                $pattern = '#^' . $pattern . '$#';

                // If the pattern matches, return the controller, method, and dynamic parameters
                if (preg_match($pattern, $path, $matches)) {
                    $dynamicParameters = [];

                    foreach ($matches as $key => $match) {
                        if (is_string($key)) {
                            $dynamicParameters[$key] = $match;
                        }
                    }

                    $routeSegments = explode('/', $routePath);
                    $method = isset($routeSegments[1]) && strpos($routeSegments[1], ':') === false ? $routeSegments[1] : 'index';

                    // Check if the necessary keys exist in $routeData before accessing them
                    if (isset($routeData['controller']) && isset($routeData['roles'])) {
                        if (empty($routeData['roles']) || in_array($role, $routeData['roles'])) {
                            return [
                                'controller' => $routeData['controller'],
                                'method' => $method,
                                'params' => $dynamicParameters ?: null,
                            ];
                        } else {
                            return [
                                'controller' => 'errors',
                                'method' => 'index',
                                'params' => 401,
                            ];
                        }
                    } else {
                        return [
                            'controller' => 'errors',
                            'method' => 'index',
                            'params' => 404,
                        ];
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
                return [
                    'controller' => $this->routes[$controller]['controller'], 
                    'method' => $method,
                    'params' => null
                ];
            } else {
                return [
                    'controller' => 'errors',
                    'method' => 'index',
                    'params' => 401,
                ];
            }
        }
    
        return [
            'controller' => 'errors',
            'method' => 'index',
            'params' => 404,
        ];
    }
    
}