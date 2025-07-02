<?php
require_once __DIR__ . '/../support/autoload.php';
require_once __DIR__ . '/../support/Core/helpers.php';
session_start();

/**
 * File: public/index.php
 *
 * This is the front controller of the application — the single entry point
 * for all HTTP requests. Every request to the application is routed through this file.
 *
 * Responsibilities of this file:
 * - Bootstrap the application
 * - Handle incoming HTTP requests
 * - Dispatch the matched route
 *
 * It typically loads the routing system and any necessary setup before running the app.
 * This setup ensures a clean and centralized flow of control.
 * 
 */
if (!isset($_SESSION['_csrf_token'])) {
    $_SESSION['_csrf_token'] = bin2hex(random_bytes(32));
}
set_error_handler(function ($errno, $errstr, $errfile, $errline) {
    $errfile = \Support\Core\Log::shortenPath($errfile);
    \Support\Core\Log::error("Error: [$errno] $errstr in file $errfile in line $errline");
    $trace = [
        "# Fatal error: [$errno] $errstr",
        "# in file $errfile at line $errline {$errline['line']}"
    ];

    \Support\Core\Log::error("Fatal error occurred", $trace);
    http_response_code(500);
    include __DIR__ . '/../support/errors/error.php';
    exit;
});

set_exception_handler(function ($exception) {
    $errfile = \Support\Core\Log::shortenPath($exception->getFile());
    \Support\Core\Log::error(
        $exception->getMessage(),
        $exception->getTraceAsString()
    );
    http_response_code(500);
    include __DIR__ . '/../support/errors/exception.php';
    exit;
});

register_shutdown_function(function () {
    $error = error_get_last();
    
    
    if ($error && in_array($error['type'], [E_ERROR, E_PARSE, E_CORE_ERROR, E_COMPILE_ERROR])) {
        $errfile = \Support\Core\Log::shortenPath($error['file']);
        $trace = [
            "# Fatal error: {$error['message']}",
            "# in file $errfile at line {$error['line']}"
        ];

        \Support\Core\Log::error("Fatal error occurred", $trace);
        
        http_response_code(500);
        include __DIR__ . '/../support/errors/fatal.php';
        exit;
    }
});

require_once __DIR__ . '/../support/Core/routes.php';

