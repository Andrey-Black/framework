<?php

namespace Core;

use function Helper\dd;

class Router
{

// Ключом является регулярное выражение для проверки URL, а значением — массив с параметрами маршрута.
protected static array $routes = [];

// Хранит текущий маршрут после его сопоставления
protected static array $route = [];

// Добавляет маршрут в список маршрутов
public static function add(string $regex, array $route = []): void
{
    self::$routes[$regex] = $route;
}

public static function getRoutes (): array
{
    return self::$routes;
}


public static function getRoute (): array
{
    return self::$route;
}

protected static function removeQueryString ($url)
{
    if ($url)
    {
        $params = explode('?', $url, 2);
        if(false === str_contains($params[0], '='))
        {
            return rtrim($params[0], '/');
        }

    }
    return '';
}

public static function dispatch ($url): void
{   
    $url = self::removeQueryString($url);

    if (self::findRoute($url)) 
    {
        self::handleController();
    } 
    else 
    {
        self::handleNotFound('Page not found');
    }
}

protected static function handleController (): void
{
    $controller = 'App\\Controllers\\' . self::$route['admin_prefix'] . self::$route['controller'] . 'Controller';

    if (!class_exists($controller)) 
    {
        self::handleNotFound ("Controller {$controller} not found");
    }

    $controllerObject = new $controller(self::$route);

    $action = self::lowerCamelCase (self::$route['action'] . 'Action');

    if (!method_exists($controllerObject, $action)) 
    {
        self::handleNotFound ("Method {$controller}::{$action} not found");
    }

    $controllerObject->$action ();
}

protected static function handleNotFound (string $message): void
{
throw new \Exception($message, 404);
}

public static function findRoute (string $url): bool
{
    foreach (self::$routes as $regex => $route) 
    {
        if (self::matchRegex ($regex, $url, $route)) 
        {
            self::setRouteDefaults ($route);
            self::convertControllerName ($route);
            self::$route = $route;
            return true;
        }
    }
    return false;
}

// Проверяет, соответствует ли URL заданному шаблону маршрута
// & Передача параметра ссылкой, # органичитель регулярки
protected static function matchRegex (string $regex, string $url, array &$route): bool
{
    if (preg_match("#{$regex}#", $url, $matches)) {
        foreach ($matches as $key => $value) {
            if (is_string($key)) 
            {
                $route[$key] = $value;
            }
        }
        return true;
    }
    return false;
}

// Устанавливает значения по умолчанию для маршрута
protected static function setRouteDefaults (array &$route): void
{
    if (empty($route['action'])) 
    {
        $route['action'] = 'index';
    }
    if (!isset($route['admin_prefix'])) 
    {
        $route['admin_prefix'] = '';
    } 
    else 
    {
        $route['admin_prefix'] .= '\\';
    }
}

protected static function convertControllerName (array &$route): void
{
    $route['controller'] = self::upperCamelCase ($route['controller']);
}

protected static function upperCamelCase (string $name): string
{
    return str_replace(' ', '', ucwords(str_replace('-', ' ', $name)));
}

protected static function lowerCamelCase (string $name): string
{
    return lcfirst(self::upperCamelCase ($name));
}

}
