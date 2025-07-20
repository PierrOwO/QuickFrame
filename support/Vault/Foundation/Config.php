<?php

namespace Support\Vault\Foundation;

class Config
{
    protected static array $configs = [];

    public static function get(string $key, $default = null)
    {
        if (empty(self::$configs)) {
            self::loadConfigs();
        }

        $keys = explode('.', $key);
        $value = self::$configs;

        foreach ($keys as $segment) {
            if (!isset($value[$segment])) {
                return $default;
            }
            $value = $value[$segment];
        }

        return $value;
    }

    protected static function loadConfigs(): void
    {
        $configDir = dirname(__DIR__, 3) . '/config/';
        foreach (glob($configDir . '*.php') as $file) {
            $name = basename($file, '.php');
            self::$configs[$name] = require $file;
        }
    }
}