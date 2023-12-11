<?php

namespace Modules\Rentalcars\Controllers;

use Tamm\Application;
use Tamm\Framework\Skeleton\Core\IController;
use Tamm\Framework\Skeleton\Web\IRequest;
use Tamm\Framework\Skeleton\Web\IRequestModel;
use Tamm\Framework\Skeleton\Web\IResponse;
use Modules\Rentalcars\Models\UpdateCarRequest;

/**
 * @RestController
 */
class RoomController implements IController 
{
    /**
     * @Get("/rooms")
     */
    public function index(IRequest $request, IResponse $response) 
    {
        echo "<h1>List all rooms.</h1>";
        echo "<pre>";
        print_r($request);
        echo "</pre>";
        echo "<h1>Hello Tamm from bnb</h1>";
    }

    /**
     * @Post("/rooms")
     */
    public function save(UpdateCarRequest $updateCar) 
    {
        // $container = Application::getContainer();
        // $request = $container->get(IRequest::class);
        echo "<h1>Save a car.</h1>";
        // print_r($request);
    }
}