<?php

require_once(__DIR__.'/configuration.php');
require_once(__DIR__.'/core/application.php');

use Tamm\Core\Application;
use Tamm\Core\HttpRequest;
use Tamm\Core\HttpResponse;
use Tamm\Core\Utilities\Collection;

$app = Application::build($configurations);

// $container = $app->getContainer();

$response = $app->run();

// $request = $container->get('Tamm\Core\HttpRequest');
//
$response->send();
// echo $app->getBasePath();
// echo $app->getRootPath();


// $responses = new Collection(new HttpResponse("","",""));

// $responses->add($app);
// $responses->add(new HttpResponse("","",""));

// echo "<pre>";
// print_r($apps);
// echo "</pre>";

require_once('a.php');
require_once('b.php');
require_once('c.php');

// use MyApp\Core\A;
// use MyApp\Core\B;
// use MyCustomApp\Core\A as AC;

// //
// echo '<pre>';
// var_dump($request);
// echo '</pre>';

$as = array();
$as[] = new MyApp\Core\A();
$as[] = new MyApp\Core\B();
$as[] = new MyCustomApp\Core\A();

$myCollection = new Collection(new \MyApp\Core\A());
$myCollection->add(new \MyApp\Core\A());
// $myCollection->add(new \MyApp\Core\B());

