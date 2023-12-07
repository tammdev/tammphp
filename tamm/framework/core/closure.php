<?php

namespace Tamm\Framework\Core;


/**
 * Class Closure
 *
 * @author  Abdullah Sowailem <abdullah.sowailem@gmail.com>
 * @package Tamm\Framework\Skelton
 */
class Closure {
    private $callable;

    public function __construct($callable) {
        $this->callable = $callable;
    }

    public function __invoke(...$args) {
        return call_user_func_array($this->callable, $args);
    }
}