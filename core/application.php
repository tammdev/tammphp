<?php

namespace Tamm\Core;

require_once(__DIR__.'/bootstrap.php');

use Tamm\Core\Bootstrap;
use Tamm\Core\Container;

class Application {

    //
    private $bootstrap;
    //
    private $container;
    //
    private $router;



    //
    private $middlewareStack = [];

    //
    public function __construct()
    {
        // echo __FUNCTION__;
        $this->bootstrap  = new Bootstrap();
        $this->container  = new Container();
        $this->router     = new Router();
    }

    //
    public function getContainer(){
        return $this->container;
    }

    public function addMiddleware(IMiddleware $middleware) {
        $this->middlewareStack[] = $middleware;
    }

    /*
    public function handleHttpRequest(HttpRequest $HttpRequest) {
        // Create a closure representing the final application logic
        $applicationLogic = function (HttpRequest $HttpRequest) {
            // Process the HttpRequest and generate a response
            // @TODO
            $statusCode = 200; 
            $headers = array(); 
            $body = "";
            $response = new HttpResponse($statusCode, $headers, $body);
            return $response;
        };

        // Build the middleware stack in reverse order
        $middlewareStack = array_reverse($this->middlewareStack);

        // Wrap the application logic with each middleware in the stack
        foreach ($middlewareStack as $middleware) {
            $applicationLogic = function (HttpRequest $HttpRequest) use ($middleware, $applicationLogic) {
                return $middleware->process($HttpRequest, $applicationLogic);
            };
        }

        // Start the HttpRequest processing with the outermost middleware
        $response = $applicationLogic($HttpRequest);

        // Return the final response
        return $response;
    }
    */

    public function run(){
        $this->bootstrap->handleHttpRequest($this->container);

        // Create a closure representing the final application logic
        $applicationLogic = function (HttpRequest $HttpRequest) {
            // Process the HttpRequest and generate a response
            // @TODO
            $statusCode = 200; 
            $headers = array(); 
            $body = "Test the request";
            $response = new HttpResponse($statusCode, $headers, $body);
            $response->setHeader('X-Framework','TammPHP');
            return $response;
        };
        // Build the middleware stack in reverse order
        $middlewareStack = array_reverse($this->middlewareStack);
        // Wrap the application logic with each middleware in the stack
        foreach ($middlewareStack as $middleware) {
            $applicationLogic = function (HttpRequest $HttpRequest) use ($middleware, $applicationLogic) {
                return $middleware->process($HttpRequest, $applicationLogic);
            };
        }
        // Start the HttpRequest processing with the outermost middleware
        $response = $applicationLogic($this->container->get('Tamm\Core\HttpRequest'));

        // Return the final response
        return $response;

    }
}