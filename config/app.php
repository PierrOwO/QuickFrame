<?php

use Support\Vault\Config\Framework;

return [
    'name' => env('APP_NAME', 'QuickFrame'),
    'version' => Framework::version(),
    'debug' => env('APP_DEBUG', true),
    'url' => env('APP_URL', 'http://localhost:8000'),
    'timezone' => 'UTC',  

    'locale' => 'en', 

    'ftp_url' => env('FTP_URL', null),
    'ftp_user' => env('FTP_USER', null),
    'ftp_password' => env('FTP_PASSWORD', null),

    'login_attempts_limit' => env('LOGIN_ATTEMPTS_LIMIT'),
    'lockout_time' => env('LOCKOUT_TIME'),

    'session' => [
        'lifetime'  => env('SESSION_LIFETIME', 1800),
        'path'      => env('SESSION_PATH', '/'),
        'domain'    => env('SESSION_DOMAIN', ''),
        'secure'    => env('SESSION_SECURE', false),
        'httponly'  => env('SESSION_HTTPONLY', true),
        'samesite'  => env('SESSION_SAMESITE', 'Lax'),
    ],
];