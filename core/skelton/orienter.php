<?php

namespace Tamm\Core\Skelton;


/**
 * Class Orienter
 *
 * @author  Abdullah Sowailem <abdullah.sowailem@gmail.com>
 * @package Tamm\Core\Skelton
 */
class Orienter {
    private $routes = [];

    public function addRoute($path, $controller, $method, $action) {
        $this->routes[$path] = [
            'controller' => $controller,
            'method' => $method,
            'action' => $action,
        ];
    }

    public function handleRequest($requestPath) {
        foreach ($this->routes as $path => $route) {
            if ($requestPath === $path) {
                $controller = new $route['controller']();
                $method = $route['method'];
                // TODO befor calling a method.
                $controller->$method();
                // TODO after called a method.
                return;
            }
        }
        // Handle route not found
        // return 404;
    }
}