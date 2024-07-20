<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

use Vendor\Core\App;

if (!version_compare(phpversion(), '8.0.0', '>')) 
{
  exit('Версія PHP ' . phpversion() . ' не підтримується');
}

require_once dirname(__DIR__) . '/config/init.php';

new App();

// echo App::$app->getProperty('pagination');
// echo App::$app->setProperty('test', 'test');
// var_dump(App::$app->getProperties());
