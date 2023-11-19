<?php

namespace Tamm\Core;

class Bootstrap
{

    function __construct()
    {
        $this->loadCoreFiles(__DIR__);
    }

    private function loadCoreFiles($dir) {
        $files = scandir($dir);
        foreach ($files as $file) {
            if ($file === '.' || $file === '..') {
                continue;
            }
            
            $path = $dir . '/' . $file;
            
            if (is_dir($path)) {
                loadCoreFiles($path);
            } elseif (is_file($path) && pathinfo($path, PATHINFO_EXTENSION) === 'php') {
                require_once $path;
            }
        }
    }

    public function handleHttpRequest(Container $container){

        // Parse the incoming HTTP request and create an instance of the HttpRequest class
        
        // Retrieve the HTTP method
        $method = $_SERVER['REQUEST_METHOD'];
    
        // Retrieve the URI
        $uri = $_SERVER['REQUEST_URI'];
    
        // Retrieve the request headers
        $headers = getallheaders();
    
        // Retrieve the request body
        $body = file_get_contents('php://input');
    
        // Retrieve the request parameters
        $params = array();
        // Retrieve all URI parameters
        $_params = $_GET;
        // Iterate over the parameters
        foreach ($_params as $name => $value) {
            $params[$name] = $value;
        }
    
        // Create an instance of the HttpRequest class
        $request = new HttpRequest($method, $uri, $headers, $body, $params);
    
        //
        $container->set('Tamm\Core\HttpRequest',$request);
    
    
        // // Now you can access the different components of the request using the methods provided by the HttpRequest class
    
        // // Example usage:
        // echo 'HTTP Method: ' . $request->getMethod() . '<br>';
        // echo 'URI: ' . $request->getUri() . '<br>';
        // echo 'Headers: ' . print_r($request->getHeaders(), true) . '<br>';
        // echo 'Body: ' . $request->getBody() . '<br>';
        // echo 'Params: ' . print_r($request->getParams(), true) . '<br>';
    
    }
    
    
}