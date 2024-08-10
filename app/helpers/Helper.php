<?php

namespace Helper;

class Helper
{

  public static function checkPhpVersion()
  {
    if (version_compare(phpversion(), '8.0.0', '<')) {
      exit('Используется версия PHP ' . phpversion() . ' Версия не может быть ниже 8.0.0');
    }
  }
}

/**
 * Выводит отладочную информацию и завершает выполнение скрипта.
 *
 * @param mixed $data Данные для вывода.
 * @param bool $exit Если true, скрипт завершает выполнение после вывода данных.
 */
function dd($data, $exit = false)
{
    echo '<pre>' . htmlspecialchars(print_r($data, true)) . '</pre>';
    if ($exit) exit();
}
