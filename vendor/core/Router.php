<?php

namespace Core;

class Router
{
  protected static array $routes = [];
  protected static array $route = [];

  public static function add($regex, $route = [])
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

public static function dispatch($url)
{
  var_dump($url);
}

}
