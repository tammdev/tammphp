<?php

require_once(__DIR__.'/configuration.php');
require_once(__DIR__.'/tamm/application.php');

use Tamm\Application;
// use Tamm\Core\Skelton\Container;
use Tamm\Core\Skelton\HttpRequest;
// use Tamm\Core\Skelton\HttpResponse;
// use Tamm\Core\Utilities\Collection;

$app = Application::build($configurations);

$container = Application::getContainer();

print_r($container);

$response = $app->run();

$request = $container->get(HttpRequest::class);
print_r($request);
//
$response->send();
echo $app->getBasePath();
echo $app->getRootPath();


