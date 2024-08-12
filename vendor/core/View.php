<?php

namespace Core;

use function Helper\dd;

class View
{
  public string $content = '';

  public function __construct(
    public array $route,
    public string $layout = '',
    public string $view = '',
    public array $meta = []
  ) {
    $this->initializeLayout();
  }

  private function initializeLayout(): void
  {
    if (false !== $this->layout) {
      $this->layout = $this->layout ?: LAYOUT;
    }
  }

  public function render(array $data): void
  {
    $this->extractData($data);
    $this->renderView();
    $this->renderLayout();
  }

  private function extractData(array $data): void
  {
    if (!empty($data)) {
      extract($data);
    }
  }

  private function renderView(): void
  {
    $viewFile = $this->getViewFilePath();

    if (is_file($viewFile)) {
      $this->content = $this->getBufferedContent($viewFile);
    } else {
      $this->handleMissingFile($viewFile, 'View');
    }
  }

  private function renderLayout(): void
  {
    if (false !== $this->layout) {
      $layoutFile = $this->getLayoutFilePath();

      if (is_file($layoutFile)) {
        require $layoutFile;
      } else {
        $this->handleMissingFile($layoutFile, 'Template');
      }
    }
  }

  private function getViewFilePath(): string
  {
    $prefix = $this->getRoutePrefix();
    return APP . "/views/{$prefix}{$this->route['controller']}/{$this->view}.php";
  }

  private function getLayoutFilePath(): string
  {
    return APP . "/views/layouts/{$this->layout}.php";
  }

  private function getRoutePrefix(): string
  {
    return str_replace('\\', '/', $this->route['admin_prefix']);
  }

  private function getBufferedContent(string $filePath): string
  {
    ob_start();
    require $filePath;
    return ob_get_clean();
  }

  private function handleMissingFile(string $filePath, string $fileType): void
  {
    throw new \Exception("{$fileType} not found: {$filePath}", 404);
  }

  public function getMeta(): string
  {
    return $this->generateMetaTags();
  }

  private function generateMetaTags(): string
  {
    return <<<META
        <title>{$this->meta['title']}</title>
        <meta name="description" content="{$this->meta['description']}">
        <meta name="keywords" content="{$this->meta['keywords']}">
        META;
  }
}
