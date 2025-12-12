<?php

return [

    'default' => 'public',
    'file_max_size' => (int)env('FILE_MAX_SIZE', 20971520),

    'disks' => [

        'public' => [
            'root' => base_path('storage/app/public'),
            'url'  => '/assets',
            'visibility' => 'public'
        ],

        'local' => [
            'root' => base_path('storage/app'),
            'visibility' => 'private'
        ],

        'private' => [
            'root' => base_path('storage/app/private'),
            'url'  => '/private',
            'visibility' => 'private'
        ],

        'temp' => [
            'root' => base_path('storage/temp'),
            'visibility' => 'private'
        ],

    ]

];