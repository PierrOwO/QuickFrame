<?php 

namespace Support\Vault\Errors;

use Support\Vault\Sanctum\Log;

class ErrorHandler
{
    public static function register()
    {
        set_error_handler([self::class, 'handleError']);
        set_exception_handler([self::class, 'handleException']);
        register_shutdown_function([self::class, 'handleShutdown']);
    }

    public static function handleError($errno, $errstr, $errfile, $errline)
    {
        $errfile = Log::shortenPath($errfile);
        Log::error("Error: [$errno] $errstr in file $errfile in line $errline");

        $trace = [
            "# Fatal error: [$errno] $errstr",
            "# in file $errfile at line $errline"
        ];

        Log::error("Fatal error occurred", $trace);

        http_response_code(500);
        include __DIR__ . '/Pages/error.php';
        exit;
    }

    public static function handleException($exception)
    {
        $errfile = Log::shortenPath($exception->getFile());

        Log::error(
            $exception->getMessage(),
            $exception->getTraceAsString()
        );

        http_response_code(500);
        include __DIR__ . '/Pages/exception.php';
        exit;
    }

    public static function handleShutdown()
    {
        $error = error_get_last();

        if ($error && in_array($error['type'], [E_ERROR, E_PARSE, E_CORE_ERROR, E_COMPILE_ERROR])) {
            $errfile = Log::shortenPath($error['file']);
            $trace = [
                "# Fatal error: {$error['message']}",
                "# in file $errfile at line {$error['line']}"
            ];

            Log::error("Fatal error occurred", $trace);

            http_response_code(500);
            include __DIR__ . '/Pages/fatal.php';
            exit;
        }
    }
}