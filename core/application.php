<?php

namespace Tamm\Core;

require_once(__DIR__.'/bootstrap.php');

use Tamm\Core\Bootstrap;
use Tamm\Core\Container;

class Application {

    //
    public const VERSION = "1.0.0";
    //
    private static Bootstrap $bootstrap;
    //
    private static Container $container;
    //
    private Router $router;
    //
    private $configuration;
    //
    private $middlewares = [];

    // The only way we can get an object from Application class
    // by the method build().
    private function __construct($configuration = array())
    {
        $this->configuration    = $configuration;
        // $this->bootstrap        = new Bootstrap();
        // $this->container        = new Container();
        // //
        // $this->container->set('Tamm\Core\Router',new Router());
        // // $this->middlewares      = $configuration['middlewares'];
    }

    public static function build($configuration = array()){
        self::$bootstrap = new Bootstrap(new self($configuration));
        self::$container = self::$bootstrap->getContainer();
        return self::$bootstrap->getApplication();
    }

    //
    public function getContainer(){
        return $this->container;
    }

    //
    public function getBasePath(){
        // return __DIR__.'/';
        $filePath = debug_backtrace()[0]['file']; // Get the current file path
        $basePath = dirname($filePath); // Extract the directory path
        return $basePath.'/';
    }

    //
    public function getRootPath(){
        return $this->configuration['root_path'];
    }

    public function addMiddleware(IMiddleware $middleware) {
        $this->middlewares[] = $middleware;
    }

    public function handleRequest(HttpRequest $request) {
        // Create a closure representing the final application logic
        $applicationLogic = function (HttpRequest $request) {
            // Process the request and generate a response
            $response = new HttpResponse(200,array(),"Hellow");
            return $response;
        };

        // Build the middleware stack in reverse order
        $middlewares = array_reverse($this->middlewares);

        // Wrap the application logic with each middleware in the stack
        foreach ($middlewares as $middleware) {
            $applicationLogic = function (HttpRequest $request) use ($middleware, $applicationLogic) {
                return $middleware->process($request, $applicationLogic);
            };
        }

        // Start the request processing with the outermost middleware
        $response = $applicationLogic($request);

        // Return the final response
        return $response;
    }

    public function run(){
        self::$bootstrap->handleHttpRequest(self::$container);

        // Create a closure representing the final application logic
        $applicationLogic = function (HttpRequest $httpRequest) {
            // Process the HttpRequest and generate a response
            // @TODO
            $statusCode = 200; 
            $headers = array(); 
            $body = "Test the request";
            $response = new HttpResponse($statusCode, $headers, $body);
            $response->setHeader('X-Framework','TammPHP '.self::VERSION);
            return $response;
        };
        // // Build the middleware stack in reverse order
        // $middlewareStack = array_reverse($this->middlewareStack);
        // // print_r($middlewareStack);
        // // Wrap the application logic with each middleware in the stack
        // foreach ($middlewareStack as $_middleware) {
        //     $middleware = new $_middleware();
        //     $closure = new Closure([$middleware, 'process']);
        //     // Using the Closure instance in the framework
        //     $this->addMiddleware($closure);

        //     $applicationLogic = function (HttpRequest $HttpRequest) use ($middleware, $applicationLogic) {
        //         return $middleware->process($HttpRequest, $applicationLogic);
        //     };
        // }
        // Start the HttpRequest processing with the outermost middleware
        $response = $applicationLogic(self::$container->get('Tamm\Core\HttpRequest'));

        // Return the final response
        return $response;

    }
}