<?php

namespace Core;

use function Helper\dd;

class ErrorHandler
{
    public function __construct()
    {
        error_reporting(DEBUG ? -1 : 0);
        set_exception_handler([$this, 'exceptionHandler']);
        set_error_handler([$this, 'errorHandler']);
        register_shutdown_function([$this, 'fatalErrorHandler']);
    }

    public function fatalErrorHandler(): void
    {
        $error = error_get_last();

        if ($error && in_array($error['type'], [E_ERROR, E_CORE_ERROR, E_COMPILE_ERROR, E_USER_ERROR], true)) {

            $this->logError($this->formatErrorMessage($error['message'], $error['file'], $error['line']));

            $this->handleError($error['message'], $error['file'], $error['line'], $error['type']);
        }
    }

    public function errorHandler(int $errNo, string $errStr, string $errFile, int $errLine): void
    {

        $this->logError($this->formatErrorMessage($errStr, $errFile, $errLine));

        $this->handleError($errStr, $errFile, $errLine, $errNo);
    }


    public function exceptionHandler(\Throwable $e): void
    {
        $this->logError($this->formatErrorMessage($e->getMessage(), $e->getFile(), $e->getLine()));

        $this->handleError($e->getMessage(), $e->getFile(), $e->getLine(), $e->getCode());
    }


    protected function formatErrorMessage(string $message, string $file, int $line): string
    {
        return sprintf("[%s] Error: %s in %s on line %d\n", date('Y-m-d H:i:s'), $message, $file, $line);
    }

    protected function logError(string $logMessage): void
    {
        error_log($logMessage, 3, LOGS . '/error.log');
    }


    protected function handleError(string $errStr, string $errFile, int $errLine, int $response): void
    {
        $this->setHttpResponseCode($response);

        $this->displayErrorTemplate($errStr, $errFile, $errLine, $response);
    }

    protected function setHttpResponseCode(int $response): void
    {
        if (!headers_sent()) {
            http_response_code($response);
        }
    }


    protected function displayErrorTemplate(string $errStr, string $errFile, int $errLine, int $response): void
    {
        extract(compact('errStr', 'errFile', 'errLine', 'response'));

        $template = $this->getErrorTemplate($response);
        require $template;
        exit;
    }


    protected function getErrorTemplate(int $response): string
    {
        if ($response === 404 && !DEBUG) {
            return PUBLIC_DIR . '/templates/error/404.php';
        }
        return DEBUG ? PUBLIC_DIR . '/templates/error/development.php' : PUBLIC_DIR . '/templates/error/production.php';
    }
}
