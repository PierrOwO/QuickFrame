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

    'session' => [
        'lifetime' => 1800,
        'path' => '/',
        'domain' => '',
        'secure' => true,
        'httponly' => true,
        'samesite' => 'Strict',
    ],
];