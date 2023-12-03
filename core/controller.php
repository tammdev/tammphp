<?php

namespace Tamm\Core;

abstract class Controller
{
    protected $view;

    public function __construct()
    {
        $this->view = new Template();
    }
}