<?php

namespace Core;

class Registry {

  // Использует трейт для реализации паттерна Singleton
  use Singleton;

  // Хранит свойства, установленные в реестре
  protected static array $properties = [];

  public function setProperty ($name, $value): void
  {
      self::$properties[$name] = $value;
  }

  public function getProperty ($name): array
  {
    return self::$properties[$name] ?? null;
  }

  // Возвращает все свойства из реестра
  public function getProperties (): array
  {
    return self::$properties;
  }

}
