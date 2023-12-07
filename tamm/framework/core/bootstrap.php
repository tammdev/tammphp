<?php

namespace Tamm\Framework\Core;

// require_once(__DIR__.'/application.php');

use Tamm\Application;
use Tamm\Framework\Core\Container;
use Tamm\Framework\Skelton\Core\IController;
use Tamm\Framework\Skelton\Web\IRequest;
use Tamm\Framework\Skelton\Web\IRequestBuilder;
use Tamm\Framework\Web\HttpRequest;
use Tamm\Framework\Web\HttpRequestBuilder;

use Tamm\Framework\Annotations\RestControllerAnnotationHandler;
use Tamm\Framework\Debug\ErrorHandler;
use Tamm\Modules\Check\Controllers\CheckController;

// The only way we can get an object from Bootstrap class
// by the method build inside the Application class.

/**
 * Class Bootstrap
 *
 * @author  Abdullah Sowailem <abdullah.sowailem@gmail.com>
 * @package Tamm\Framework\Skelton
 */
class Bootstrap
{
    private Application $application;
    private Container $container;

    public function __construct(Application $application)
    {
        // add a new autoloader by passing a callable into spl_autoload_register()
        spl_autoload_register([__CLASS__, 'autoloader']);
        // $this->loadCoreFiles(__DIR__);
        // $this->loadCoreFiles(__DIR__.'/../middlewares/');
        //
        $this->application  = $application;
        $this->container    = new Container($application);


        
    }

    private function registerAllControllers()
    {
        //
        $clazzHandler = $this->container->get(RestControllerAnnotationHandler::class);
        //
        $classes = $this->container->getImplementingClasses(IController::class);
        //
        foreach($classes as $clazz)
        {
            $clazzHandler->handleAnnotations($clazz);
        }
    }

    public function booting(){
        //
        $this->container->set(new ErrorHandler());

        //
        $this->container->set(new Orienter());

        //
        $this->container->set(new RestControllerAnnotationHandler());

        //
        $this->loadControllersFromModules();
        //
        $this->registerAllControllers();
    }

    /**
     * Function autoloader
     *
     * @param $class_name - String name for the class that is trying to be loaded.
     */
    public static function autoloader( $className ){
        // echo $className.'<br>';
        $className = self::classToFileName($className);
        // echo $className.'<br>';
        $file = $className.'.php';
        // echo $file.'<br>';
        if ( file_exists($file) ) {
            require_once $file;
        }
    }

    public static function classToFileName($className) {
        $snakeCase = strtolower(preg_replace('/(?<!^)[A-Z]/', '_$0', $className));
        $snakeCase = str_replace("\\_","/",$snakeCase);
        return $snakeCase;
    }

    // private function loadCoreFiles($dir) {
    //     $files = scandir($dir);
    //     foreach ($files as $file) {
    //         if ($file === '.' || $file === '..') {
    //             continue;
    //         }
            
    //         $path = $dir . '/' . $file;
            
    //         if (is_dir($path)) {
    //             $this->loadCoreFiles($path);
    //         } elseif (is_file($path) && pathinfo($path, PATHINFO_EXTENSION) === 'php') {
    //             require_once $path;
    //         }
    //     }
    // }

    //
    public function getContainer(){
        return $this->container;
    }

    //
    public function getApplication(){
        return $this->application;
    }

    //
    private function loadControllersFromModules() {
        
        $path = "tamm/modules";
        $modulesPath = $this->getApplication()->getRootPath() . rtrim($path, '/') . '/';
        // print_r($modulesPath);
        $modules = glob($modulesPath . '*', GLOB_ONLYDIR);
        
        $activeModules = Application::getConfigurationValue("modules");
        $targetModules = array();
        foreach($activeModules as $activeModule)
        {
            $targetModules[] = $modulesPath.$activeModule;
        }
        // print_r($modules);
        // print_r($activeModules);
        foreach ($modules as $module) {
            if(in_array($module,$targetModules))
            {
                $moduleControllersPath = $module . '/controllers';
                $controllers = glob($moduleControllersPath . '/*_controller.php');
        
                foreach ($controllers as $controller) {
                    require_once $controller;
                }
            }
        }
    }

    public function handleHttpRequest(){
        // echo '<pre>';
        // print_r($_SERVER);
        // echo '</pre>';

        // Parse the incoming HTTP request and create an instance of the HttpRequest class
        
        // Retrieve the HTTP method
        $method = $_SERVER['REQUEST_METHOD'];

        //
        $host = $_SERVER['HTTP_HOST'];

        //
        $port = $_SERVER['SERVER_PORT'];
    
        // Retrieve the URI
        $uri = "/".$_SERVER['REQUEST_URI'];
        $basePath = Application::getConfigurationValue("base_path");
        $uri = str_replace($basePath,"",$uri);
    
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
        
        //
        $this->container->bind(IRequest::class,HttpRequest::class);
        //
        // $this->container->bind(IRequestBuilder::class,HttpRequestBuilder::class);

        $requestConcrete = $this->container->resolve(IRequest::class);
        

        // Create an instance of the HttpRequest class
        $request = $requestConcrete::builder()
                    ->withMethod($method)
                    ->withHost($host)
                    ->withPort($port)
                    ->withUri($uri)
                    ->withHeaders($headers)
                    ->withParams($params)
                    ->withBody($body)
                    ->build();
        // ($method, $uri, $headers, $body, $params);

        //
        $this->container->set($request);

        // echo '<pre>';
        // print_r($request);
        // echo '</pre>';
        

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