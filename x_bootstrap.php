<?php

// require_once('container.php');
// require_once('router.php');
// require_once('controller.php');
// require_once('model.php');
// require_once('database.php');
// require_once('template.php');
function loadCoreFiles($dir) {
    $files = scandir($dir);
    foreach ($files as $file) {
        if ($file === '.' || $file === '..') {
            continue;
        }
        
        $path = $dir . '/' . $file;
        
        if (is_dir($path)) {
            loadCoreFiles($path);
        } elseif (is_file($path) && pathinfo($path, PATHINFO_EXTENSION) === 'php') {
            require_once $path;
        }
    }
}

$core = __DIR__;
loadCoreFiles($core);

use Tamm\Core\HttpRequest;
use Tamm\Core\Container;
use Tamm\Core\Router;


/*
// Set the session save handler to use the database
ini_set('session.save_handler', 'db');
ini_set('session.save_path', 'mysql:host=localhost;dbname=session_db');

// Register a custom session save handler
session_set_save_handler(
    new DatabaseSessionHandler(), // Custom session save handler class
    true // Register the session save handler as the default
);

// Start the session
session_start();
*/


$container  = new Container();
$router     = new Router();

// handling functions
handleHttpRequest($container);

/*
// Get module and theme information from the database
$modules = $container->resolve('Tamm\Core\Database')->query("SELECT * FROM modules")->fetchAll();
$themes = $container->resolve('Tamm\Core\Database')->query("SELECT * FROM themes")->fetchAll();

foreach ($modules as $module) {
    $router->registerModule($module['name'], $module['path']);
}

foreach ($themes as $theme) {
    $router->registerTheme($theme['name']);
}
*/

$router->addRoute('/', 'HomeController@index');

$template = $container->resolve('Tamm\Core\Template');
$template->setTheme('ThemeName'); // Set the active theme

// Add blocks to regions
$template->addBlockToRegion('Block 1', 'header');
$template->addBlockToRegion('Block 2', 'sidebar');
$template->addBlockToRegion('Block 3', 'main');
$template->addBlockToRegion('Block 4', 'footer');

$router->handle($_SERVER['REQUEST_URI']);


function handleHttpRequest($container){

    // Parse the incoming HTTP request and create an instance of the HttpRequest class
    
    // Retrieve the HTTP method
    $method = $_SERVER['REQUEST_METHOD'];

    // Retrieve the URI
    $uri = $_SERVER['REQUEST_URI'];

    // Retrieve the request headers
    $headers = getallheaders();

    // Retrieve the request body
    $body = file_get_contents('php://input');

    // Retrieve the request parameters
    $params = array();
    // Retrieve all URI parameters
    $_params = $_GET;
    // Iterate over the parameters
    foreach ($_params as $name => $value) {
        $params[$name] = $value;
    }

    // Create an instance of the HttpRequest class
    $request = new HttpRequest($method, $uri, $headers, $body, $params);

    //
    $container->set('Tamm\Core\HttpRequest',$request);


    // // Now you can access the different components of the request using the methods provided by the HttpRequest class

    // // Example usage:
    // echo 'HTTP Method: ' . $request->getMethod() . '<br>';
    // echo 'URI: ' . $request->getUri() . '<br>';
    // echo 'Headers: ' . print_r($request->getHeaders(), true) . '<br>';
    // echo 'Body: ' . $request->getBody() . '<br>';
    // echo 'Params: ' . print_r($request->getParams(), true) . '<br>';

}