<?php

namespace Vendor\Core;

class Registry {

  use Singleton;

  protected static array $properties = [];

  public function setProperty($name, $value)
  {
      self::$properties[$name] = $value;
  }

  public function getProperty($name)
  {
    return self::$properties[$name] ?? null; 
  }

  public function getProperties(): array
  {
    return self::$properties;
  }

}