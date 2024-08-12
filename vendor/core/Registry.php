<?php

namespace Core;

use function Helper\dd;

class Registry
{
  use Singleton;

  protected static array $properties = [];

  public function setProperty(string $name, mixed $value): void
  {
    self::$properties[$name] = $value;
  }

  public function getProperty(string $name): mixed
  {
    return self::$properties[$name] ?? null;
  }

  public function getProperties(): array
  {
    return self::$properties;
  }
}
