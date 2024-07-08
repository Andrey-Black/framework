<?php

if (!version_compare(phpversion(), '8.0.0', '>=')) 
{
  exit('Версія PHP ' . phpversion() . ' не підтримується');
}

require_once dirname(__DIR__) . '/config/init.php';
