<?php

namespace Tamm\Core\Skelton;


/**
 * Class Controller
 *
 * @author  Abdullah Sowailem <abdullah.sowailem@gmail.com>
 * @package Tamm\Core\Skelton
 */
abstract class Controller
{
    protected $view;

    public function __construct()
    {
        $this->view = new Template();
    }
}