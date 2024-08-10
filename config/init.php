<?php

// Корневая папка проекта
define('ROOT', dirname(__DIR__));

// Режим отладки (1 - включен, 0 - выключен)
define('DEBUG', 1);

// Папка для публично доступных файлов
define('PUBLIC_DIR', ROOT . '/public');

// Папка с файлами приложения
define('APP', ROOT . '/app');

// Папка с ядром фреймворка
define('CORE', ROOT . '/vendor/core');

// Папка для кэша
define('CACHE', ROOT . '/tmp/cache');

// Папка с конф файлами
define('CONFIG', ROOT . '/config');

// Папка для логов
define('LOGS', ROOT . '/tmp');

// Имя загрузаемого шаблона по умолчанию
define('LAYOUT', "TEST");

// Базовый URL сайта
define('PATH', "https://localhost");

// URL админ панели
define('ADMIN', "https://localhost/admin");

// Путь к изображению по умолчанию, если изображение не найдено
define('NO_IMAGE', "upload/no_image.jpg");

require_once ROOT . '/vendor/autoload.php';
