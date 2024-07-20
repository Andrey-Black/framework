<?php

namespace Core;

class ErrorHandler 
{
  public function __construct()
  {
    if(DEBUG)
    {
      error_reporting(-1);
    }
    else
    {
      error_reporting(0);
    }

    set_exception_handler([$this, 'exeptionHandler']);
    set_error_handler([$this, 'errorHandler']);
    ob_start();
    register_shutdown_function([$this, 'FatalErrorHandler']);
  }

  public function fatalErrorHandler()
  {
      $error = error_get_last();

      if ($error && in_array($error['type'], [E_ERROR, E_CORE_ERROR, E_COMPILE_ERROR, E_USER_ERROR], true)) {
          $logMessage = $this->formatErrorMessage($error['message'], $error['file'], $error['line']);
          $this->logError($logMessage);
          $this->displayError($error['message'], $error['file'], $error['line'], $error['type']);
      }
  }

  public function errorHandler($errNo = '', $errStr = '', $errFile = '', $errLine = '')
  {
    $logMessage = $this->formatErrorMessage($errStr, $errFile, $errLine);

    $this->logError($logMessage);

    $this->displayError($errStr, $errFile, $errLine, $errNo);
  }

  public function exeptionHandler(\Throwable $e)
  {
    $logMessage = $this->formatErrorMessage($e->getMessage(), $e->getFile(), $e->getLine());

    $this->logError($logMessage);

    $this->displayError($e->getMessage(), $e->getfile(), $e->getLine(), $e->getCode());
  }
  
  protected function formatErrorMessage($message = '', $file = '', $line = '')
  {
      return sprintf(
      "[%s] Error: %s in %s on line %d (Code: %d)\n",
      date('Y-m-d H:i:s'),
      $message,
      $file,
      $line,
  );
  }

  protected function logError($logMessage)
  {
    error_log($logMessage, 3, LOGS . '/error.log'); // 2 argument: record type
  }

  protected function displayError($errNo = '', $errStr = '', $errFile = '', $errLine = '', $response = 500)
  {

    http_response_code($response === 0 ? 404 : $response);

    if($response === 404 && !DEBUG)
    {
      require PUBLIC_DIR . 'error/404.php';
      exit;
    }

    if(DEBUG)
    {
      require PUBLIC_DIR . 'error/development.php';
    }
    else
    {
      require PUBLIC_DIR . 'error/production.php';
    }
    exit;
  }

}
