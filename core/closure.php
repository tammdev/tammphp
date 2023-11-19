<?php

namespace Tamm\Core;

class Closure {
    private $callable;

    public function __construct($callable) {
        $this->callable = $callable;
    }

    public function __invoke(...$args) {
        return call_user_func_array($this->callable, $args);
    }
}