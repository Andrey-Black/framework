<?php

namespace Core;

use function Helper\dd;

abstract class Controller
{
  public array $data = [];
  public array $meta = ['title' => '', 'description' => '', 'keywords' => ''];
  public false|string $layout = '';
  public string $view = '';
  public object $model;

  public function __construct(public array $route = []) {}

  public function getModel(): void
  {
    $this->createModelInstance();
  }

  protected function getModelClassName(): string
  {
    return 'App\Models\\' . $this->route['admin_prefix'] . $this->route['controller'];
  }

  protected function createModelInstance(): void
  {
    $modelClassName = $this->getModelClassName();
    if (class_exists($modelClassName)) {
      $this->model = new $modelClassName();
    }
  }

  public function getView(): void
  {
    $this->view = $this->view ?: $this->route['action'];
    $view = $this->createView();
    $this->renderView($view);
  }

  protected function createView(): View
  {
    return new View($this->route, $this->layout, $this->view, $this->meta);
  }

  protected function renderView(View $view): void
  {
    $view->render($this->data);
  }

  public function setData(array $data): void
  {
    $this->data = $data;
  }

  public function setMeta(string $title = '', string $description = '', string $keywords = ''): void
  {
    $this->meta = [
      'title' => $title,
      'description' => $description,
      'keywords' => $keywords
    ];
  }
}
