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
    $cacheFile = base_path('storage/cache/config.php');

    $cacheValid = false;

    if (file_exists($cacheFile)) {
        $cacheTime = filemtime($cacheFile);
        $configFiles = glob(base_path('config/*.php'));
        $latestConfigTime = max(array_map('filemtime', $configFiles));

        if ($cacheTime !== false && $cacheTime >= $latestConfigTime) {
            $cacheValid = true;
        }
    }

    if ($cacheValid) {
        self::$configs = include $cacheFile;
        return;
    }

    $config = [];
    foreach (glob(base_path('config/*.php')) as $file) {
        $key = basename($file, '.php');
        $config[$key] = include $file;
    }

    $export = var_export($config, true);
    $content = "<?php\nreturn $export;\n";
    $cacheDir = dirname($cacheFile);

    if (!is_dir($cacheDir)) {
        mkdir($cacheDir, 0755, true);
    }

    file_put_contents($cacheFile, $content);
    self::$configs = $config;
}
}