<?php

namespace Tamm\Core\Skelton;

/**
 * Class Container
 *
 * @author  Abdullah Sowailem <abdullah.sowailem@gmail.com>
 * @package Tamm\Core\Skelton
 */
class Container
{
    protected $bindings = [];
    private $instances = [];
    private Application $application; 

    public function __construct(Application $application)
    {
        // echo __FUNCTION__;
        $this->application = $application;
    }

    public function set($object) 
    {
        $reflectionClass = new \ReflectionClass($object);
        $className = $reflectionClass->getName();
        // echo $className; exit;
        if (!isset($this->instances[$className])) {
            $this->instances[$className] = $object;
            return true;
        }
        return false;
    }

    public function get($className) 
    {
        if (isset($this->instances[$className])) {
            return $this->instances[$className];
        }
        return null;
    }

    public function bind($abstract, $concrete)
    {
        if (!isset($this->bindings[$abstract])) {
            $this->bindings[$abstract] = $concrete;
            return true;
        }
        return false;
    }

    public function resolve($abstract)
    {
        if (isset($this->bindings[$abstract])) {
            $concrete = $this->bindings[$abstract];
            return $concrete($this);
        }

        return null;
    }
}