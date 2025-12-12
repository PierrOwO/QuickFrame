<?php

namespace Support\Libs;

class LibPrefixes
{
    public static function all(): array
    {
        $base_path = dirname(__DIR__, 2);
        return [
            'PHPMailer\\PHPMailer\\' => $base_path . '/support/Libs/PHPMailer/',
            'Carbon\\' => $base_path . '/support/Libs/Carbon/',
            'Lazy\\' => $base_path . '/support/lazy/',
            'Symfony\\' => $base_path . '/support/Libs/Symfony/',
            'Psr\\' => $base_path . '/support/Libs/Psr/',
            'chillerlan\\' => $base_path . '/support/Libs/chillerlan/',
            'QRCode\\' => $base_path . '/support/Libs/QRCode/',
            'Masterminds\\' => $base_path . '/support/Libs/Masterminds/',
            'TCPDFWrapper\\' => $base_path . '/support/Libs/TCPDFWrapper/',
            'Picqer\\Barcode\\' => $base_path . '/support/Libs/php-barcode-generator-main/src/',
            'Barcode\\' => $base_path . '/support/Libs/Barcode/',
        ];
    }
}