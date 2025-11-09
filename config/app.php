<?php

use Support\Vault\Config\Framework;

return [
    'env' => env('APP_ENV', 'development'),
    'name' => env('APP_NAME', 'QuickFrame'),
    'version' => env('APP_VERSION', '1.0.0'),
    'version_framework' => Framework::version(),
    'debug' => filter_var(env('APP_DEBUG', true), FILTER_VALIDATE_BOOLEAN),
    'url' => env('APP_URL', 'http://localhost:8000'),
    'timezone' => 'UTC',  

    'locale' => 'en', 

    'ftp_url' => env('FTP_URL', null),
    'ftp_user' => env('FTP_USER', null),
    'ftp_password' => env('FTP_PASSWORD', null),

    'login_attempts_limit' => env('LOGIN_ATTEMPTS_LIMIT'),
    'lockout_time' => env('LOCKOUT_TIME'),

    'session' => [
        'lifetime' => (int) env('SESSION_LIFETIME', 1800),
        'path' => env('SESSION_PATH', '/'),
        'domain' => env('SESSION_DOMAIN', ''),
        'httponly' => filter_var(env('SESSION_HTTPONLY', true), FILTER_VALIDATE_BOOLEAN),
        'secure' => filter_var(env('SESSION_SECURE', false), FILTER_VALIDATE_BOOLEAN),
        'samesite' => env('SESSION_SAMESITE', 'Lax'),
    ],
];