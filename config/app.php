<?php

use Support\Vault\Config\Framework;

return [
    'name' => env('APP_NAME', 'QuickFrame'),
    'version' => Framework::version(),
    'debug' => env('APP_DEBUG', true),
    'url' => env('APP_URL', 'http://localhost:8000'),

    'timezone' => 'UTC',  

    'locale' => 'en', 
];