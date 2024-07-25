<?php

namespace Core;

trait Singleton
{
  private static ?self $instance = null;

  private function __construct () {}

  public static function getInstance () : static
  {
    return static::$instance ?? static::$instance = new static ();
  }
}
