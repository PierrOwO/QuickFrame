<?php

return [
    'driver' => env('MAIL_DRIVER', 'smtp'),

    'host' => env('MAIL_HOST', 'smtp.mailtrap.io'),
    'port' => env('MAIL_PORT', 2525),

    'username' => env('MAIL_USERNAME'),
    'password' => env('MAIL_PASSWORD'),

    'encryption' => env('MAIL_ENCRYPTION', 'tls'),

    'from' => [
        'address' => env('MAIL_FROM_ADDRESS', 'no-reply@example.com'),
        'name' => env('MAIL_FROM_NAME', 'QuickFrame'),
    ],
];