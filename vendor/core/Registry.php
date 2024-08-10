<?php

namespace Core;

use function Helper\dd;

class Registry
{
  use Singleton;

  // Переменная для хранения свойств реестра.
  protected static array $properties = [];

  // Устанавливает свойство в реестре.
  public function setProperty(string $name, $value): void
  {
    self::$properties[$name] = $value;
  }

  // Получает значение свойства из реестра.
  public function getProperty(string $name)
  {
    return self::$properties[$name] ?? null;
  }

  // Возвращает все свойства из реестра.
  public function getProperties(): array
  {
    return self::$properties;
  }
}
