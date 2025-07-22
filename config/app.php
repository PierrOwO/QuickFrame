<?php

use Support\Vault\Config\Framework;

return [
    'name' => env('APP_NAME', 'QuickFrame'),
    'version' => Framework::version(),
    'debug' => env('APP_DEBUG', true),
    'url' => env('APP_URL', 'http://localhost:8000'),
    'session_timeout' => env('SESSION_TIMEOUT', 1800),
    'timezone' => 'UTC',  

    'locale' => 'en', 

    'ftp_url' => env('FTP_URL', null),
    'ftp_user' => env('FTP_USER', null),
    'ftp_password' => env('FTP_PASSWORD', null),
];