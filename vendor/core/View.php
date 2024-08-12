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
      // Буферизация вывода страницы и запись результата буферизации в content
      ob_start();
      require $viewFile;
      $this->content = ob_get_clean();
    } else {
      throw new \Exception("View not found {$viewFile}", 404);
    }

    if (false !== $this->layout) {
      $layoutFile = APP . "/views/layouts/{$this->layout}.php";

      if (is_file($layoutFile)) {
        require $layoutFile;
      } else {
        throw new \Exception("Template not found {$layoutFile}", 404);
      }
    }
  }
}
