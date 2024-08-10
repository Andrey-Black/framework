<?php

use Core\Router;

// Маршрут для главной админ панели
Router::add('^admin/?$', ['controller' => 'Main', 'action' => 'index', 'admin_prefix' => 'admin']);

// Маршрут для всех контроллеров и действий в админ панели
Router::add('^admin/(?P<controller>[a-z-]+)/?(?P<action>[a-z-]+)?$', ['admin_prefix' => 'admin']);

// Маршрут для главной страницы сайта
Router::add('^$', ['controller' => 'Main', 'action' => 'index']);

// Маршрут для всех контроллеров и действий на сайте
Router::add('^(?P<controller>[a-z-]+)/(?P<action>[a-z-]+)/?$');
