<?php

namespace Tamm\Modules\Check\Controllers;

use Tamm\Framework\Skelton\Core\IController;


/**
 * @RestController
 */
class CheckController implements IController 
{
    /**
     * @Get("/checks")
     */
    public function index() 
    {
        echo "<h1>Hello Tamm</h1>";
    }

    /**
     * @Get("/cars")
     */
    public function cars()
    {
        echo "<h1>All Cars goes here.....</h1>";
    }
}