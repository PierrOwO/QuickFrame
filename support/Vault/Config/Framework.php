<?php

namespace Support\Vault\Config;

class Framework
{
    public static function version(): string
    {
        $jsonPath = __DIR__ . '/quickframe.json';
        if (!file_exists($jsonPath)) {
            return 'unknown';
        }

        $config = json_decode(file_get_contents($jsonPath), true);
        return $config['version'] ?? 'unknown';
    }
}