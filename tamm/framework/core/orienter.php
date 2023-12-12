<?php

namespace Tamm\Framework\Core;

use stdClass;
use Tamm\Application;
use Tamm\Framework\Skeleton\Web\IRequest;
use Tamm\Framework\Utilities\DynamicImplementation;

/**
 * Class Orienter
 *
 * @author  Abdullah Sowailem <abdullah.sowailem@gmail.com>
 * @package Tamm\Framework\Core
 */
class Orienter
{
    private $routes = [];

    public function addRoute($path, $controller, $method, $callback, $args = array())
    {
        $this->routes[$method][$path] = [
            'controller' => $controller,
            // 'method' => $method,
            'callback' => $callback,
            'args' => $args,
        ];
    }

    public function handleRequest(IRequest $request)
    {
        foreach ($this->routes as $method => $paths) {
            if ($request->getMethod() === $method) {
                foreach ($paths as $path => $route) {
                    if ($request->getUri() === $path) {
                        $controller = new $route['controller']();
                        $callback = $route['callback'];
                        // TODO befor calling a method.
                        if (empty($route['args'])) {
                            $content = $controller->$callback();
                        } else {
                            $args = array();
                            foreach ($route['args'] as $arg) {
                                $resolver = Application::getContainer()->resolve($arg);
                                $obj = Application::getContainer()->get($resolver);
                                // var_dump($arg);
                                if ($obj !== null) {
                                    $args[] = $obj;
                                } else {
                                    if (class_exists($arg)) {
                                        $args[] = new $arg();
                                    } else {
                                        // TODO needs more attention
                                        $args[] = DynamicImplementation::implement($arg);
                                    }
                                }
                            }
                            $content = $controller->$callback(...$args);

                        }
                        // TODO after called a method.
                        return;
                    }
                }
            }
        }
        // Handle route not found
        // return 404;
    }
}
