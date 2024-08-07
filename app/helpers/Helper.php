<?php

namespace Helper;

class Helper
{

public static function checkPhpVersion ()
{
  if (version_compare(phpversion(), '8.0.0', '<')) 
  {
    exit ('Используется версия PHP ' . phpversion() . ' Версия не может быть ниже 8.0.0');
  }
}

}

function dd ($data, $exit = false)
{
  echo '<pre>' . print_r ($data, 1) . '</pre>';
  if ($exit) exit ();
}
