<?php

namespace Tamm\Core\Skelton;

require_once(__DIR__.'/application.php');

use Tamm\Core\Annotations\RestControllerAnnotationHandler;

// The only way we can get an object from Bootstrap class
// by the method build inside the Application class.

/**
 * Class Bootstrap
 *
 * @author  Abdullah Sowailem <abdullah.sowailem@gmail.com>
 * @package Tamm\Core\Skelton
 */
class Bootstrap
{
    private Application $application;
    private Container $container;

    public function __construct(Application $application)
    {
        $this->loadCoreFiles(__DIR__);
        $this->loadCoreFiles(__DIR__.'/../middlewares/');
        //
        $this->application  = $application;
        $this->container    = new Container($application);
    }

    private function loadCoreFiles($dir) {
        $files = scandir($dir);
        foreach ($files as $file) {
            if ($file === '.' || $file === '..') {
                continue;
            }
            
            $path = $dir . '/' . $file;
            
            if (is_dir($path)) {
                $this->loadCoreFiles($path);
            } elseif (is_file($path) && pathinfo($path, PATHINFO_EXTENSION) === 'php') {
                require_once $path;
            }
        }
    }

    //
    public function getContainer(){
        return $this->container;
    }

    //
    public function getApplication(){
        return $this->application;
    }

    //
    public function loadControllersFromModules() {
        $path = "modules";
        $modulesPath = rtrim($path, '/') . '/';
        $modules = glob($modulesPath . '*', GLOB_ONLYDIR);
    
        foreach ($modules as $module) {
            $moduleControllersPath = $module . '/controllers';
            $controllers = glob($moduleControllersPath . '/*_controller.php');
    
            foreach ($controllers as $controller) {
                require_once $controller;
            }
        }
    }

    public function handleHttpRequest(){

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
        // $this->container->set('Tamm\Core\HttpRequest',$request);
        $this->container->set($request);

        //
        $this->container->set(new RestControllerAnnotationHandler());
    
    
        // // Now you can access the different components of the request using the methods provided by the HttpRequest class
    
        // // Example usage:
        // echo 'HTTP Method: ' . $request->getMethod() . '<br>';
        // echo 'URI: ' . $request->getUri() . '<br>';
        // echo 'Headers: ' . print_r($request->getHeaders(), true) . '<br>';
        // echo 'Body: ' . $request->getBody() . '<br>';
        // echo 'Params: ' . print_r($request->getParams(), true) . '<br>';
    
    }
    
    
}