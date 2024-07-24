<?php

use Core\Router;

if (!version_compare(phpversion(), '8.0.0', '>')) 
{
    exit('PHP version ' . phpversion() . ' not suported');
}

require_once dirname(__DIR__) . '/config/init.php';
require_once HELPER . '/functions.php';
require_once CONFIG . '/routes.php';

new \Core\App();

debug(Router::getRoutes());
