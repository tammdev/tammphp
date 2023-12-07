<?php

namespace Tamm\Framework\Core;


/**
 * Class Controller
 *
 * @author  Abdullah Sowailem <abdullah.sowailem@gmail.com>
 * @package Tamm\Framework\Core
 */
class Controller
{
    protected $view;

    public function __construct()
    {
        $this->view = new Template();
    }
}