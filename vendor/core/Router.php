<?php

namespace Core;

class Router
{
    protected static array $routes = [];
    protected static array $route = [];

    public static function add(string $regex, array $route = []): void
    {
        self::$routes[$regex] = $route;
    }

    public static function getRoutes(): array
    {
        return self::$routes;
    }

    public static function getRoute(): array
    {
        return self::$route;
    }

    public static function dispatch(string $url): void
    {
        if (self::matchRoute($url)) {
            echo 'OK';
        } else {
            echo 'NO';
        }
    }

    public static function matchRoute(string $url): bool
    {
        foreach (self::$routes as $pattern => $route) {
            if (self::matchPattern($pattern, $url, $route)) {
                self::setRouteDefaults($route);
                self::convertControllerName($route);
                self::$route = $route;
                return true;
            }
        }
        return false;
    }

    protected static function matchPattern(string $pattern, string $url, array &$route): bool
    {
        if (preg_match("#{$pattern}#", $url, $matches)) {
            foreach ($matches as $key => $value) {
                if (is_string($key)) {
                    $route[$key] = $value;
                }
            }
            return true;
        }
        return false;
    }

    protected static function setRouteDefaults(array &$route): void
    {
        if (empty($route['action'])) {
            $route['action'] = 'index';
        }
        if (!isset($route['admin_prefix'])) {
            $route['admin_prefix'] = '';
        } else {
            $route['admin_prefix'] .= '\\';
        }
    }

    protected static function convertControllerName(array &$route): void
    {
        $route['controller'] = self::upperCamelCase($route['controller']);
    }

    protected static function upperCamelCase(string $name): string
    {
        return str_replace(' ', '', ucwords(str_replace('-', ' ', $name)));
    }

    protected static function lowerCamelCase(string $name): string
    {
        return lcfirst(self::upperCamelCase($name));
    }
}
