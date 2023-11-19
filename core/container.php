<?php

namespace Tamm\Core;

class Container
{
    protected $bindings = [];
    private $instances = [];

    public function __construct()
    {
        // echo __FUNCTION__;
    }

    // public function listInstances(){
    //     // print_r($this->instances);
    // }

    public function set($className, $object) {
        if (!isset($this->instances[$className])) {
            $this->instances[$className] = $object;
        }
    }

    public function get($className) {
        if (isset($this->instances[$className])) {
            return $this->instances[$className];
        }
        return null;
    }

    public function bind($abstract, $concrete)
    {
        $this->bindings[$abstract] = $concrete;
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