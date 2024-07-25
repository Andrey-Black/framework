<?php

namespace Core;

class Registry {

  use Singleton;

  protected static array $properties = [];

  public function setProperty ($name, $value): void
  {
      self::$properties[$name] = $value;
  }

  public function getProperty ($name): array
  {
    return self::$properties[$name] ?? null;
  }

  public function getProperties (): array
  {
    return self::$properties;
  }

}
