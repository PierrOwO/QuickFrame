<?php
namespace Support\Vault\Config;

use RecursiveDirectoryIterator;
use RecursiveIteratorIterator;
use Support\Vault\Foundation\ViewCompiler;
use Support\Vault\Routing\Route;
require __DIR__ . '/../Foundation/helpers.php';

class CliHandlerFunctions
{

    public static function updateEnvValue(string $key, string $value): void
    {
        $envPath = __DIR__ . '../../../.env'; 

        if (!file_exists($envPath)) {
            echo " .env file not found at $envPath\n";
            exit(1);
        }

        $content = file_get_contents($envPath);

        if (preg_match("/^{$key}=.*/m", $content)) {
            $content = preg_replace("/^{$key}=.*/m", "{$key}={$value}", $content);
        } else {
            $content .= PHP_EOL . "{$key}={$value}";
        }

        file_put_contents($envPath, $content);
    }
    public static function clearCache(string $type)
    {
        $cacheDir = base_path("storage/cache/$type");
        if (!is_dir($cacheDir)) {
            return;
        }
        $files = glob($cacheDir . '/*');
        foreach ($files as $file) {
            if (is_file($file)) {
                unlink($file);
            }
        }
    }
    public static function cacheRoutes()
    {
        self::clearCache('routes');

        require base_path('routes/api.php');
        require base_path('routes/auth.php');

        Route::saveCache();
        echo "Routes cache generated\n";
    }

    public static function cacheViews()
    {
        self::clearCache('views');

        $compiler = new ViewCompiler;

        $viewsPath = base_path('resources/views');

        $iterator = new RecursiveIteratorIterator(
            new RecursiveDirectoryIterator($viewsPath)
        );

        foreach ($iterator as $file) {
            if ($file->isFile() && str_ends_with($file->getFilename(), '.frame.php')) {
                $relativePath = str_replace(
                    ['\\', $viewsPath . '/', '.frame.php'],
                    ['/', '', ''],
                    $file->getPathname()
                );

                try {
                    $compiler->compile($relativePath);
                } catch (\Exception $e) {
                    echo "Failed to compile view [$relativePath]: {$e->getMessage()}\n";
                }
            }
        }

        echo "Views cache generated.\n";
    }
}