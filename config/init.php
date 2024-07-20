<?php

define('ROOT', dirname(__DIR__));
define('DEBUG', 1);
define('PUBLIC', ROOT . '/public');
define('APP', ROOT . '/app');
define('CORE', ROOT . '/vendor/core');
define('HELPER', ROOT . '/vendor/core/helper');
define('CACHE', ROOT . '/tmp/cache');
define('CONFIG', ROOT . '/config');
define('LOGS', ROOT . '/tmp');
define('LAYOUT', "TEST");
define('PATH', "https://localhost");
define('ADMIN', "https://localhost/admin");
define('NO_IMAGE', "upload/no_image.jpg");

require_once ROOT . '/vendor/autoload.php';
