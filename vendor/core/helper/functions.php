<?php

function debug($data, $exit = false)
{
  echo '<pre>' . print_r($data, 1) . '</pre>';
  $exit ? true : exit;
}
