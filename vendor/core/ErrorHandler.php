<?php
namespace Core;

class ErrorHandler 
{
public function __construct ()
{
    // Регистрируем уровень отчетности об ошибках
    error_reporting (DEBUG ? -1 : 0);

    // Регистрируем обработчики исключений и ошибок
    set_exception_handler ([$this, 'exceptionHandler']);
    set_error_handler ([$this, 'errorHandler']);
    register_shutdown_function ([$this, 'fatalErrorHandler']);
}

public function fatalErrorHandler (): void
{
    $error = error_get_last ();

    if ($error && in_array($error['type'], [E_ERROR, E_CORE_ERROR, E_COMPILE_ERROR, E_USER_ERROR], true)) 
    {
        // Логируем ошибку
        $this->logError($this->formatErrorMessage ($error['message'], $error['file'], $error['line']));
        // Обрабатываем ошибку
        $this->handleError ($error['message'], $error['file'], $error['line'], $error['type']);
    }
}

public function errorHandler ($errNo, $errStr, $errFile, $errLine): void
{
    $this->logError ($this->formatErrorMessage ($errStr, $errFile, $errLine));
    $this->handleError ($errStr, $errFile, $errLine, $errNo);
}

// Throwable нативный php интерфейс
public function exceptionHandler (\Throwable $e): void
{
    $this->logError ($this->formatErrorMessage($e->getMessage(), $e->getFile(), $e->getLine()));
    $this->handleError ($e->getMessage(), $e->getFile(), $e->getLine(), $e->getCode());
}

// Форматирует сообщение об ошибке
protected function formatErrorMessage ($message, $file, $line): string
{
    return sprintf ("[%s] Error: %s in %s on line %d\n", date ('Y-m-d H:i:s'), $message, $file, $line);
}

protected function logError ($logMessage): void
{
    error_log ($logMessage, 3, LOGS . '/error.log');
}

// Устанавливает код ответа HTTP и отображает шаблон ошибки
protected function handleError ($errStr, $errFile, $errLine, $response): void
{
    $this->setHttpResponseCode ($response);
    $this->displayErrorTemplate ($errStr, $errFile, $errLine, $response);
}

protected function setHttpResponseCode ($response): void
{
    if (!headers_sent ()) 
    {
        http_response_code ($response);
    }
}

// Отображает шаблон ошибки
protected function displayErrorTemplate ($errStr, $errFile, $errLine, $response): void
{
    extract(compact('errStr', 'errFile', 'errLine', 'response'));

    $template = $this->getErrorTemplate ($response);
    require $template;
    exit;
}

// Возвращает путь к шаблону ошибки в зависимости от кода ответа и режима отладки
protected function getErrorTemplate ($response): string
{
    if ($response === 404 && !DEBUG) 
    {
        return PUBLIC_DIR . '/templates/error/404.php';
    } 
    return DEBUG ? PUBLIC_DIR . '/templates/error/development.php' : PUBLIC_DIR . '/templates/error/production.php';
}

}
