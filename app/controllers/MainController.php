<?php

namespace App\Controllers;

use Core\Controller;

class MainController extends Controller
{
  public function indexAction()
  {
    $this->setMeta('Главная страница', 'Описание', 'Ключевые слова');
  }
}
