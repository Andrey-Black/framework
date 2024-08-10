<?php

namespace Core;

use function Helper\dd;

class View
{
  // 
  public string $content = '';

  public function __construct(public $route, public $layout = '', public $view = '', $meta = [])
  {
    if (false !== $this->layout) {
      // Если $this->layout пуст, будет использовано значение константы.
      $this->layout = $this->layout ?: LAYOUT;
    }
  }

  public function render($data)
  {
    if (is_array($data)) {
      extract($data);
    }
    // $prefix замена слеша на коректный для пути
    $prefix = str_replace('\\', '/', $this->route['admin_prefix']);

    $viewFile = APP . "/views/{$prefix}{$this->route['controller']}/{$this->view}.php";
    if (is_file($viewFile)) {
      require $viewFile;
    } else {
      throw new \Exception("View not found {$viewFile}");
    }
  }
}
