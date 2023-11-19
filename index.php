<?php

require_once('configuration.php');
require_once('core/application.php');

use Tamm\Core\Application;

$app = new Application();
$container = $app->getContainer();



$response = $app->run();


$request = $container->get('Tamm\Core\HttpRequest');
//
echo $response->send();
//
echo '<pre>';
print_r($request);
echo '</pre>';
