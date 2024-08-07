<?php

namespace Core;

abstract class Controller
{

public array $data = [];
public array $meta = ['title' => '', 'description' => '', 'keywords' => ''];
public false|string $layout = '';
public string $view = '';
public object $model;
  
public function __construct (public $route)
{
  
}

public function getModel (): void
{
  $model = 'App\Models\\' . $this->route['admin_prefix'] . $this->route['controller'];
  if (class_exists ($model))
  {
    $this->model = new $model ();
  }
}

public function getView (): void
{
  $this->view = $this->view ?: $this->route['action'];
}

public function set ($data): void
{
  $this->data = $data;
}

public function setMeta ($title = '', $description = '', $keywords = ''): void
{
  $this->meta = 
  [
    'title' => $title, 'description' => $description, 'keywords' => $keywords
  ];
}

}
