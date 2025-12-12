<?php

namespace Support\Vault\Foundation;

class Config
{
    protected static array $configs = [];
    protected static bool $loaded = false;

    public static function get(string $key, $default = null)
    {
        if (!self::$loaded) {
            self::loadConfigs();
        }

        $value = self::$configs;
        foreach (explode('.', $key) as $segment) {
            if (!is_array($value) || !array_key_exists($segment, $value)) {
                return $default;
            }
            $value = $value[$segment];
        }

        return $value;
    }

    protected static function loadConfigs(): void
    {
        $cacheFile = base_path('storage/cache/config.php');
        $configDir = base_path('config');

        $configFiles = glob($configDir . '/*.php') ?: [];
        $latestConfigTime = 0;

        foreach ($configFiles as $file) {
            $time = filemtime($file);
            if ($time > $latestConfigTime) {
                $latestConfigTime = $time;
            }
        }

        $envFile = base_path('.env');
        $envTime = file_exists($envFile) ? filemtime($envFile) : 0;

        $cacheValid = false;

        if (file_exists($cacheFile)) {
            $cacheTime = filemtime($cacheFile);
            if ($cacheTime >= max($latestConfigTime, $envTime)) {
                $cacheValid = true;
            }
        }

        // Load from cache
        if ($cacheValid) {
            self::$configs = include $cacheFile;
            self::$loaded = true;
            return;
        }

        // Rebuild config
        $config = [];
        foreach ($configFiles as $file) {
            $key = basename($file, '.php');
            $config[$key] = include $file;
        }

        // Cache it
        $cacheDir = dirname($cacheFile);
        if (!is_dir($cacheDir)) {
            mkdir($cacheDir, 0755, true);
        }

        $export = var_export($config, true);
        file_put_contents($cacheFile, "<?php\nreturn $export;\n");

        self::$configs = $config;
        self::$loaded = true;
    }
}