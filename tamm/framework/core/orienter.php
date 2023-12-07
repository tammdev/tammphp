<?php

namespace Tamm\Framework\Core;

use Tamm\Application;
use Tamm\Framework\Skelton\Web\IRequest;

/**
 * Class Orienter
 *
 * @author  Abdullah Sowailem <abdullah.sowailem@gmail.com>
 * @package Tamm\Framework\Core
 */
class Orienter {
    private $routes = [];

    public function addRoute($path, $controller, $method, $callback) {
        $this->routes[$path] = [
            'controller' => $controller,
            'method' => $method,
            'callback' => $callback,
        ];
    }

    public function handleRequest(IRequest $request) {
        foreach ($this->routes as $path => $route) {
            if ($request->getUri() === $path) {
                if($request->getMethod() === $route['method']){
                    $controller = new $route['controller']();
                    $callback = $route['callback'];
                    // TODO befor calling a method.
                    $controller->$callback();
                    // TODO after called a method.
                    return;
                }
            }
        }
        // Handle route not found
        // return 404;
    }
}