<?php

use Core\App;
use Core\ErrorHandler;
use Helper\Helper;
use Core\Router;

require_once dirname(__DIR__) . '/config/init.php';
require_once CONFIG . '/routes.php';

Helper::checkPhpVersion();

new ErrorHandler();
new App();
new Router;
