<?php

namespace Modules\Rentalcars\Controllers;

use Tamm\Framework\Skeleton\Core\IController;
use Tamm\Framework\Skeleton\Web\IRequest;
use Tamm\Framework\Skeleton\Web\IResponse;
use Modules\Rentalcars\Models\UpdateCarRequest;

/**
 * @RestController
 */
class CarController implements IController 
{
    /**
     * @Get("/cars")
     */
    public function index(IRequest $request, IResponse $response) 
    {
        echo "<h1>List all cars.</h1>";
        echo "<pre>";
        print_r($request);
        echo "</pre>";
        echo "<h1>Hello Tamm from rentalcars</h1>";
    }

    /**
     * @Post("/cars")
     */
    public function save(UpdateCarRequest $updateCar) 
    {
        // $container = Application::getContainer();
        // $request = $container->get(IRequest::class);
        echo "<h1>Save a car.</h1>";
        // print_r($request);
    }
}