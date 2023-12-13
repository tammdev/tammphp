<?php

require_once(__DIR__.'/configuration.php');
require_once(__DIR__.'/tamm/application.php');

use Tamm\Application;

$app = Application::build($configurations);
// $response = $app->run();
$app->run();

$container = Application::getContainer();

echo "<h1>Welcome to ".$app->environment->getApplicationName()."!!</h1>";
echo "<!--You are running under '" .$app->environment->getName()."' environment.-->";