<?php

namespace Tamm\Framework\Core;

// require_once(__DIR__.'/application.php');

use Tamm\Application;
use Tamm\Framework\Core\Container;
use Tamm\Framework\Skeleton\Core\IController;
use Tamm\Framework\Skeleton\Web\IRequest;
use Tamm\Framework\Skeleton\Web\IRequestBuilder;
use Tamm\Framework\Web\HttpRequest;
use Tamm\Framework\Web\HttpRequestBuilder;

use Tamm\Framework\Annotations\RestControllerAnnotationHandler;
use Tamm\Framework\Debug\ErrorHandler;
use Tamm\Framework\Skeleton\Web\IResponse;
use Tamm\Framework\Web\HttpResponse;
use Tamm\Modules\Check\Controllers\CheckController;

// The only way we can get an object from Bootstrap class
// by the method build inside the Application class.

/**
 * Class Bootstrap
 *
 * @author  Abdullah Sowailem <abdullah.sowailem@gmail.com>
 * @package Tamm\Framework\Skeleton
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
        $this->container->set(new RestControllerAnnotationHandler());

        //
        $this->container->set(new Orienter());


        //
        $coreModules = $this->loadtargetModules();
        $this->loadControllersFromTargetModules($coreModules);
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
    private function loadtargetModules() {
        
        $modulesPath = rtrim($this->getApplication()->getRootPath(), '/') . '/';
        $activeModules = Application::getConfigurationValue("modules");
        // print_r($activeModules);
        $targetModules = array();
        foreach($activeModules as $activeModule)
        {
            if(str_contains($activeModule,"/"))
            {
                // echo $activeModule;
                $targetModules[] = $modulesPath.'tamm/modules/'.explode("/",$activeModule)[1];
            }else{
                $targetModules[] = $modulesPath.'modules/'.$activeModule;
            }
        }

        return $targetModules;
    }
    //
    private function loadControllersFromTargetModules($targetModules = array()) {
        // $path = $path . "modules";
        // $modulesPath = rtrim($this->getApplication()->getRootPath(), '/') . rtrim($path, '/') . '/';
        // // print_r($modulesPath);
        // $modules = glob($modulesPath . '*', GLOB_ONLYDIR);
        // // print_r($modules);
        
        // $activeModules = Application::getConfigurationValue("modules");
        // $targetModules = array();
        // foreach($activeModules as $activeModule)
        // {
        //     $targetModules[] = $modulesPath.$activeModule;
        // }
        // print_r($modules);
        // print_r($activeModules);

        
        // print_r($modules);
        foreach ($targetModules as $module) {
            // echo $module;
            // if(in_array($module,$targetModules))
            // {
                $moduleControllersPath = $module . '/controllers';
                $controllers = glob($moduleControllersPath . '/*_controller.php');
        
                foreach ($controllers as $controller) {
                    require_once $controller;
                }
            // }
        }
    }

    public function handleHttpRequest(){
        //
        $this->container->bind(IRequest::class,HttpRequest::class);
        //
        $this->container->set(HttpRequest::getInstance());
        //
        $this->container->bind(IResponse::class,HttpResponse::class);
        //
        $this->container->set(new HttpResponse());
    }
    
    
}