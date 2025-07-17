<?php

namespace Support\Vault\Errors;

use Support\Vault\Sanctum\Log;

class Abort 
{
    public static function code(int $statusCode, string $message = '')
    {
        http_response_code($statusCode);

        switch ($statusCode) {
            case 401:
                return view('errors/401', ['message' => $message ?? 'Unauthorized']);
                break;
            case 403:
                return view('errors/403', ['message' => $message ?? 'Forbidden']);
                break;
            case 404:
                return view('errors/404', ['message' => $message ?? "Not found"]);
                break;
            default:
                $view = __DIR__ . '/../../errors/error.php';
                break;
        }

        if (!empty($message)) {
            Log::error("Abort $statusCode: $message");
        }

        include $view;
        exit;
    }

    public static function unauthorized($message = 'Unauthorized')
    {
        self::code(401, $message);
    }

    public static function forbidden($message = 'Forbidden')
    {
        self::code(403, $message);
    }

    public static function notFound($message = 'Not Found')
    {
        self::code(404, $message);
    }
}