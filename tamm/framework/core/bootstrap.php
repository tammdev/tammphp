<?php

namespace Tamm\Framework\Core;

use Tamm\Application;
use Tamm\Framework\Core\Container;
use Tamm\Framework\Skeleton\Core\IController;
use Tamm\Framework\Skeleton\Web\IRequest;
use Tamm\Framework\Web\HttpRequest;

use Tamm\Framework\Annotations\AnnotationsRouteHandler;
use Tamm\Framework\Debug\ErrorHandler;
use Tamm\Framework\Skeleton\Web\IResponse;
use Tamm\Framework\Web\HttpResponse;

// The only way we can get an object from Bootstrap class
// by the method build() inside the Application class.

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

    public function booting(){
        //
        $this->container->set(new ErrorHandler());
        //
        $this->container->set(new AnnotationsRouteHandler());
        //
        $this->container->set(new Orienter());
        //
        $coreModules = $this->loadTargetModules();
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
        // 
        $className = self::classToFileName($className);
        // 
        $file = $className.'.php';
        // 
        if ( file_exists($file) ) {
            require_once $file;
        }
    }
    //
    public static function classToFileName($className) {
        $snakeCase = strtolower(preg_replace('/(?<!^)[A-Z]/', '_$0', $className));
        $snakeCase = str_replace("\\_","/",$snakeCase);
        return $snakeCase;
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
    //
    private function registerAllControllers()
    {
        //
        $clazzHandler = $this->container->get(AnnotationsRouteHandler::class);
        //
        $classes = $this->container->getImplementingClasses(IController::class);
        //
        foreach($classes as $clazz)
        {
            $clazzHandler->handleAnnotations($clazz);
        }
    }
    //
    private function loadTargetModules() {
        //    
        $modulesPath = rtrim($this->getApplication()->getRootPath(), '/') . '/';
        $activeModules = Application::getConfigurationValue("modules");
        // 
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
        //
        return $targetModules;
    }
    //
    private function loadControllersFromTargetModules($targetModules = array()) {      
        // 
        foreach ($targetModules as $module) {
            // 
            $moduleControllersPath = $module . '/controllers';
            $controllers = glob($moduleControllersPath . '/*_controller.php');
            //
            foreach ($controllers as $controller) {
                require_once $controller;
            }
        }
    }   
}