<?php

require_once(__DIR__.'/configuration.php');
require_once(__DIR__.'/tamm/core/skelton/application.php');

use Tamm\Core\Skelton\Application;
// use Tamm\Core\HttpRequest;
// use Tamm\Core\HttpResponse;
// use Tamm\Core\Utilities\Collection;

$app = Application::build($configurations);

// $container = $app->getContainer();

$response = $app->run();

// $request = $container->get(HttpRequest::class);
//
$response->send();
echo $app->getBasePath();
echo $app->getRootPath();


