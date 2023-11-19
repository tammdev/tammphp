<?php

namespace Tamm\Core;

class Controller
{
    protected $view;

    public function __construct()
    {
        $this->view = new Template();
    }
}