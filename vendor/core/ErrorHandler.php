<?php

namespace Core;

class ErrorHandler 
{
    public function __construct()
    {
        error_reporting(DEBUG ? -1 : 0);

        set_exception_handler([$this, 'exceptionHandler']);
        set_error_handler([$this, 'errorHandler']);
        ob_start();
        register_shutdown_function([$this, 'fatalErrorHandler']);
    }

    public function fatalErrorHandler()
    {
        $error = error_get_last();

        if ($error && in_array($error['type'], [E_ERROR, E_CORE_ERROR, E_COMPILE_ERROR, E_USER_ERROR], true)) 
        {
            $this->logError($this->formatErrorMessage($error['message'], $error['file'], $error['line']));
            $this->displayError($error['message'], $error['file'], $error['line'], $error['type']);
        }
    }

    public function errorHandler($errNo, $errStr, $errFile, $errLine)
    {
        $this->logError($this->formatErrorMessage($errStr, $errFile, $errLine));
        $this->displayError($errStr, $errFile, $errLine, $errNo);
    }

    public function exceptionHandler(\Throwable $e)
    {
        $this->logError($this->formatErrorMessage($e->getMessage(), $e->getFile(), $e->getLine()));
        $this->displayError($e->getMessage(), $e->getFile(), $e->getLine(), $e->getCode());
    }

    protected function formatErrorMessage($message, $file, $line)
    {
        return sprintf("[%s] Error: %s in %s on line %d\n", date('Y-m-d H:i:s'), $message, $file, $line);
    }

    protected function logError($logMessage)
    {
        error_log($logMessage, 3, LOGS . '/error.log');
    }

    protected function displayError($errStr, $errFile, $errLine, $response)
    {
        http_response_code($response);

        extract(compact('errStr', 'errFile', 'errLine', 'response'));

        if ($response === 404 && !DEBUG) 
        {
            require PUBLIC_DIR . '/error/404.php';
        } 
        else 
        {
            require DEBUG ? PUBLIC_DIR . '/error/development.php' : PUBLIC_DIR . '/error/production.php';
        }

        exit;
    }
}
