<?php

namespace Core;

trait Singleton
{
    // `?self` указывает, что переменная может быть либо экземпляром
    // текущего класса (`self`), либо `null`. Изначально установлено в `null`,
    // что означает, что экземпляр класса еще не создан.
  private static ?self $instance = null;

  // Закрытый конструктор для предотвращения создания экземпляров из вне
  private function __construct () {}

  // Возвращает единственный экземпляр класса (или создает его при необходимости)
   // Если экземпляр не существует, создаем новый
  public static function getInstance (): static
  {
    return static::$instance ?? static::$instance = new static ();
  }
}
