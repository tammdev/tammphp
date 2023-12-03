<?php

require_once(__DIR__.'/configuration.php');
require_once(__DIR__.'/core/application.php');

use Tamm\Core\Application;

$app = Application::build($configurations);

// $container = $app->getContainer();

$response = $app->run();

// $request = $container->get('Tamm\Core\HttpRequest');
//
$response->send();
echo $app->getBasePath();
echo $app->getRootPath();



// //
// echo '<pre>';
// var_dump($request);
// echo '</pre>';
