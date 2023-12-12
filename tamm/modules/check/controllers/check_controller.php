<?php

namespace Tamm\Modules\Check\Controllers;


use Tamm\Application;
use Tamm\Framework\Annotations\Attributes\Get;
use Tamm\Framework\Annotations\Attributes\RestController;
use Tamm\Framework\Skeleton\Core\IController;
use Tamm\Framework\Skeleton\Web\IRequest;


#[RestController]
class CheckController implements IController 
{
    #[Get("/hello")]
    public function index() 
    {
        echo "<h1>Hello Tamm from Check.</h1>";
        $container = Application::getContainer();
        $irequest = $container->resolve(IRequest::class);
        $request = $container->get($irequest);
        echo "<pre>";
        print_r($request);
        echo "</pre>";
        echo "<br><br>Done.";
    }

    #[Get("/cars")]
    public function cars()
    {
        echo "<h1>All Cars goes here.....</h1>";
    }
}