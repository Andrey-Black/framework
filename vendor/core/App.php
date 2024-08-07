<?php

namespace Core;

class App
{
// Хранит экземпляр приложения
public static $app;

public function __construct ()
{

  // Получение очищенного URL запроса
  $query = trim(urldecode($_SERVER['REQUEST_URI']), '/');
  self::$app = Registry::getInstance ();

  // Инициализация параметров приложения
  $this->initializeParams ();

    // Поиск маршрута на основе запроса
  Router::dispatch ($query);
}

private function getConfigFilePath (): string
{
  return CONFIG . '/params.php';
}

// Проверяет наличие конфигурационного файла, завершает выполнение при отсутствии
private function checkFileConfigExists (): void
{
  $filePath = $this->getConfigFilePath ();
  if (!file_exists ($filePath)) 
  {
      throw new \RuntimeException ($filePath . ' not found');
  }
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
    foreach ($params as $key => $value) 
    {
        self::$app->setProperty ($key, $value);
    }
}

}
