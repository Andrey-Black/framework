<?php

namespace Core;

use function Helper\dd;

class App
{
  public static $app;

  public function __construct()
  {
    $query = (string) trim(urldecode($_SERVER['REQUEST_URI']), '/');
    self::$app = Registry::getInstance();
    $this->initializeParams();
    Router::dispatch($query);
  }

  private function getConfigFilePath(): string
  {
    return CONFIG . '/params.php';
  }

  private function checkFileConfigExists(): void
  {
    $filePath = $this->getConfigFilePath();
    if (!file_exists($filePath)) {
      throw new \RuntimeException($filePath . ' not found');
    }
  }

  private function loadConfigFile(): array
  {
    $this->checkFileConfigExists();
    return require $this->getConfigFilePath();
  }

  protected function initializeParams(): void
  {
    $params = $this->fetchParams();
    $this->applyParams($params);
  }

  private function fetchParams(): array
  {
    return $this->loadConfigFile();
  }

  private function applyParams(array $params): void
  {
    $this->setParams($params);
  }

  private function setParams(array $params): void
  {
    foreach ($params as $key => $value) {
      self::$app->setProperty($key, $value);
    }
  }
}
