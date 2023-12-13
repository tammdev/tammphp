<?php

$configurations = array(
    'application_name' => 'Tamm',
    'base_path' => '/tammphp/', // '/'
    'debug' => true,
    'env' => 'Development',
    'middlewares' => array(
        'Tamm\Middleware\LoggingMiddleware',
    ),
    'database' => array(
        'driver' => 'mysql',
        'host' => 'localhost',
        'database' => 'your_database_name',
        'username' => 'your_username',
        'password' => 'your_password',
        'charset' => 'utf8',
        'collation' => 'utf8_unicode_ci',
        'prefix' => 'tm_',
    ),
    'theme' => 'assas',
    'modules' => array('tamm/system','tamm/account','tamm/l10n','rentalcars','bnb', 'tamm/check')
);
