<?php

if (version_compare(phpversion(), '8.0.0', '<')) 
{
  exit ('Версия PHP ' . phpversion() . ' не может быть ниже 8.0.0');
}

use Core\Router;

require_once dirname(__DIR__) . '/config/init.php';
require_once HELPER . '/functions.php';
require_once CONFIG . '/routes.php';

new \Core\App();
