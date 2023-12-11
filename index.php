<?php

require_once(__DIR__.'/configuration.php');
require_once(__DIR__.'/tamm/application.php');

use Tamm\Application;
// use Tamm\Framework\Debug\Debug;
// use Tamm\Framework\Skeleton\Validation\IValidator;
// use Tamm\Framework\Validation\RequiredValidator;
// use Tamm\Framework\Validation\EmailValidator;
// use Tamm\Framework\Validation\MaxValidator;
// use Tamm\Framework\Validation\MinValidator;
// use Tamm\Framework\Validation\MatchValidator;

// use Tamm\Framework\Skeleton\Web\IRequest;
// // use Tamm\Framework\Core\HttpResponse;
// // use Tamm\Framework\Utilities\Collection;

$app = Application::build($configurations);
// $response = $app->run();
$app->run();

$container = Application::getContainer();
// $container->set(new EmailValidator());
// $container->set(new RequiredValidator());
// $container->set(new MinValidator());
// $container->set(new MaxValidator());
// $container->set(new MatchValidator());

// $classes = $container->getImplementingClasses(IValidator::class);
// Debug::show($classes);
// echo "<pre>";
// print_r($classes);
// echo "</pre>";
// $irequest = $container->resolve(IRequest::class);
// $request = $container->get($irequest);
// Debug::show($request);

// //
// // $response->send();
// echo $app->getBasePath();
// echo $app->getRootPath();


