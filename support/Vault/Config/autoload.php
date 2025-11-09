<?php

spl_autoload_register(function ($class) {
    $prefixes = [
        'App\\' => dirname(__DIR__, 3) . '/app/',
        'Support\\' => dirname(__DIR__, 3) . '/support/',
        'Database\\' => dirname(__DIR__, 3) . '/database/',
        'PHPMailer\\PHPMailer\\' => dirname(__DIR__, 3) . '/support/Libs/PHPMailer/',
        'Carbon\\' => dirname(__DIR__, 3) . '/support/Libs/Carbon/',
        'Lazy\\' => dirname(__DIR__, 3) . '/support/lazy/',
        'Symfony\\' => dirname(__DIR__, 3) . '/support/Libs/Symfony/', 
        'Psr\\' => dirname(__DIR__, 3) . '/support/Libs/Psr/',
        'chillerlan\\' => dirname(__DIR__, 3) . '/support/Libs/chillerlan/',
        'QRCode\\' => dirname(__DIR__, 3) . '/support/Libs/QRCode/',
        'Masterminds\\' => dirname(__DIR__, 3) . '/support/Libs/Masterminds/',
        'TCPDFWrapper\\' => dirname(__DIR__, 3) . '/support/Libs/TCPDFWrapper/',
        'Picqer\\Barcode\\' => dirname(__DIR__, 3) . '/support/Libs/php-barcode-generator-main/src/',
        'Barcode\\' => dirname(__DIR__, 3) . '/support/Libs/Barcode/',


    ];

    foreach ($prefixes as $prefix => $base_dir) {
        if (strncmp($class, $prefix, strlen($prefix)) !== 0) {
            continue;
        }

        $relative_class = substr($class, strlen($prefix));
        $file = $base_dir . str_replace('\\', '/', $relative_class) . '.php';

        if (file_exists($file)) {
            require_once $file;
            return;
        } else {
            throw new Exception("Couldn't load class: $class\nCheck path: $file");
        }
    }
});


\Support\Vault\Errors\ErrorHandler::register();

require_once __DIR__ . '/env.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;