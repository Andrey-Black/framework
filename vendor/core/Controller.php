<?php

namespace Core;

use function Helper\dd;

abstract class Controller
{
  // Содержит данные из модели, которые мы передаем в View.
  public array $data = [];

  // Мета-теги для страницы.
  // По умолчанию содержит пустые значения для заголовка, описания и ключевых слов.
  public array $meta = ['title' => '', 'description' => '', 'keywords' => ''];

  // Имя шаблона для страницы.
  // Может быть false, если шаблон не нужен.
  public false|string $layout = '';

  // Название вида (view).
  // По умолчанию соответствует названию экшена.
  public string $view = '';

  // Экземпляр модели, используемой в контроллере.
  public object $model;

  // Конструктор контроллера.
  // Принимает маршрут как параметр.
  public function __construct(public $route = []) {}

  public function getModel(): void
  {
    $this->createModelInstance();
  }

  // Модель может быть пользовательской или админской, поэтому может быть передан admin_prefix.
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
    // Если вид не установлен, использовать экшен из маршрута.
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

  // Устанавливает данные для передачи в представление (view).
  public function set(array $data): void
  {
    $this->data = $data;
  }

  // Устанавливает мета-теги для страницы.
  public function setMeta(string $title = '', string $description = '', string $keywords = ''): void
  {
    $this->meta = [
      'title' => $title,
      'description' => $description,
      'keywords' => $keywords
    ];
  }
}
