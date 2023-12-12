<?php

namespace Tamm;

require_once(__DIR__.'/framework/core/bootstrap.php');

use Tamm\Framework\Core\Bootstrap;
use Tamm\Framework\Core\Container;
use Tamm\Framework\Core\Orienter;
use Tamm\Framework\Skeleton\Middleware\IMiddleware;

//
use Tamm\Framework\Skeleton\Web\IRequest;

/**
 * Class Application
 * 
 * 
 * @author  Abdullah Sowailem <abdullah.sowailem@gmail.com>
 * @package Tamm\Framework\Skeleton
 * @note Applies a facade pattern
 */
class Application {
    //
    public const VERSION = "1.0.0";
    // "/var/www/html/tammphp/"
    public string $rootPath;
    // "/tammphp/" or just "/"
    public string $basePath;
    //
    private static Bootstrap $bootstrap;
    //
    private static Container $container;
    //
    // private static Orienter $orienter;
    //
    private static $configuration;
    //
    private $middlewares = [];

    // The only way we can get an object from Application class
    // by the method build().
    private function __construct($configuration = array())
    {

        self::$configuration       = $configuration;

        $dir = dirname(__DIR__);
        $this->basePath = $configuration['base_path'];
        $path = explode($this->basePath, $dir);
        $this->rootPath = $path[0].'/'; //.$this->basePath;
        
        // $this->bootstrap        = new Bootstrap();
        // $this->container        = new Container();
        // //
        // $this->container->set(new Router());
        // // $this->middlewares      = $configuration['middlewares'];
    }

    public static function build($configuration = array()){
        self::$bootstrap = new Bootstrap(new self($configuration));
        self::$container = self::$bootstrap->getContainer();
        //

        //
        self::$bootstrap->booting();
        //
        return self::$bootstrap->getApplication();
    }

    //
    public static function getContainer(){
        return self::$container;
    }

    //
    public static function getBootstrap(){
        return self::$bootstrap;
    }

    //
    public static function getOrienter(){
        return self::$container->get(Orienter::class);
    }

    //
    public function getBasePath(){
        return $this->basePath;
    }

    //
    public function getRootPath(){
        return $this->rootPath;
    }

    // $key maybe "base_path" or "database/host"
    public static function getConfigurationValue($key, $target = array()) {
        if (empty($target)) {
            $target = self::$configuration;
        }
    
        $keys = explode('/', $key);
        $currentKey = array_shift($keys);
    
        foreach ($target as $key => $item) {
            if ($key === $currentKey) {
                if (empty($keys)) {
                    // Reached the final key
                    return $item;
                } elseif (is_array($item)) {
                    // Continue searching in the child array
                    return self::getConfigurationValue(implode('/', $keys), $item);
                }
            }
        }
    
        return null;
    }

    public function addMiddleware(IMiddleware $middleware) {
        $this->middlewares[] = $middleware;
    }


    public function run(){
        // self::$bootstrap->loadControllersFromModules();
        self::$bootstrap->handleHttpRequest();

        $irequest = self::$container->resolve(IRequest::class);
        $request = self::$container->get($irequest);
        //
        $orienter = $this->getOrienter();
        $orienter->handleRequest($request);

    }

}