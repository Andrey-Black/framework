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

    // Инициализация обработчика ошибок
    new ErrorHandler ();

     // Получение экземпляра реестра (контейнера зависимостей)
    self::$app = Registry::getInstance ();

      // Инициализация параметров приложения
    $this->initializeParams ();

     // Сопоставление маршрута на основе запроса
    Router::matchRoute ($query);
  }
 
  private function getConfigFilePath (): string
  {
    return CONFIG . '/params.php';
  }

  // Проверяет наличие конфигурационного файла, завершает выполнение при отсутствии
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
