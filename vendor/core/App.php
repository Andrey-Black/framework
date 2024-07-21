<?php

namespace Core;

class App
{
  
  public static $app;

  public function __construct()
  {
    new ErrorHandler();
    self::$app = Registry::getInstance();
    $this->getParams();
  }
 
  private function getConfigFilePath(): string
  {
    return CONFIG . '/params.php';
  }

  private function loadConfigFile(): array
  {
    $filePath = $this->getConfigFilePath();
    if (!file_exists($filePath)) 
    {
        exit('Error ' . $filePath  . ' not found.');
    }
    return require $filePath;
  }

  protected function getParams()
  {
      $params = $this->loadConfigFile();
      foreach($params as $key => $value)
      {
        self::$app->setProperty($key, $value);
      }
  }

}
