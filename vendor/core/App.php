<?php

namespace Core;

class App
{
  
  public static $app;

  public function __construct ()
  {
    $query = trim(urldecode($_SERVER['REQUEST_URI']), '/');

    new ErrorHandler ();

    self::$app = Registry::getInstance ();

    $this->initializeParams ();

    Router::dispatch ($query);
  }
 
  private function getConfigFilePath (): string
  {
    return CONFIG . '/params.php';
  }

  private function checkFileConfigExists (): void
  {
    file_exists ($filePath = $this->getConfigFilePath ()) ?: exit('Error ' . $filePath . ' not found.');
  }

  private function loadConfigFile (): array
  {
    $this->checkFileConfigExists ();
    return require $this->getConfigFilePath ();
  }

  protected function initializeParams (): void
  {
      $params = $this->loadConfigFile ();
      $this->setParams ($params);
  }

  private function setParams (array $params): void
  {
      foreach ($params as $key => $value) {
          self::$app->setProperty ($key, $value);
      }
  }

}
