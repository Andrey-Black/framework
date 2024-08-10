<?php

namespace Core;

use function Helper\dd;

// Реализует паттерн Singleton для обеспечения единственного экземпляра класса.
trait Singleton
{
  // Единственный экземпляр класса.
  // Изначально установлено в null, так как экземпляр еще не создан.
  private static ?self $instance = null;

  // Закрытый конструктор для предотвращения создания экземпляров класса извне.
  private function __construct() {}

  // Возвращает единственный экземпляр класса. Если экземпляр не существует, создается новый.
  // Если экземпляр уже существует, возвращается существующий.
  public static function getInstance(): static
  {
    return static::$instance ?? static::$instance = new static();
  }
}
