<?php

use Core\App;
use Core\ErrorHandler;
use Helper\Helper;
use Core\Router;

require_once dirname(__DIR__) . '/config/init.php'; // Инициализация конфигурации
require_once CONFIG . '/routes.php'; // Подключение маршрутов

Helper::checkPhpVersion(); // Проверка минимальной требуемой версии PHP

// Инициализация обработчика ошибок, приложения и маршрутизатора
new ErrorHandler;
new App;
new Router;
