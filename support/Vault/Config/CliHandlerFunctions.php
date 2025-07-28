<?php
namespace Support\Vault\Config;

use RecursiveDirectoryIterator;
use RecursiveIteratorIterator;
use Support\Vault\Foundation\ViewCompiler;
use Support\Vault\Routing\Route;
use Support\Vault\Sanctum\Log;

require __DIR__ . '/../Foundation/helpers.php';

class CliHandlerFunctions
{
    public static function updateEnvValue(string $key, string $value): void
    {
        $envPath = base_path('.env'); 

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
    public static function cacheConfig()
    {
        $configDir = base_path("storage/cache/config.php");
        if (is_file($configDir)){
            unlink($configDir);
        }
        Log::info('configDir : ' . $configDir);
        loadConfig();
        return "Config cached successfully";
    }
    public static function clearCache(string $type)
    {
        $cacheDir = base_path("storage/cache/$type");
        if (is_dir($cacheDir)) {
            $files = glob($cacheDir . '/*');
            foreach ($files as $file) {
                if (is_file($file)) {
                    unlink($file);
                }
            }
            return;
        }
        elseif (is_file("$cacheDir.php")){
            unlink("$cacheDir.php");
        }
        else{
            return;
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
    public static function serve()
    {
        $host = $argv[2] ?? '127.0.0.1';
        $requestedPort = $argv[3] ?? null;
        
        if (!filter_var($host, FILTER_VALIDATE_IP) && !preg_match('/^([a-z0-9\.\-]+)$/i', $host)) {
            echo "Invalid host: {$host}\n";
            exit;
        }
        
        $publicDir = base_path('public');
        if (!is_dir($publicDir)) {
            echo "Missing 'public' directory. Please create a 'public/' folder with an index.php file.\n";
            exit;
        }
        
        function findFreePort($host, $startPort = 8000, $maxAttempts = 100) {
            $port = $startPort;
            for ($i = 0; $i < $maxAttempts; $i++, $port++) {
                set_error_handler(function() {}, E_WARNING); 
                $connection = stream_socket_client("tcp://{$host}:{$port}", $errno, $errstr, 0.1);
                restore_error_handler(); 
                if ($connection) {
                    fclose($connection); 
                } else {
                    return $port; 
                }
            }
            return false;
        }
        
        if ($requestedPort === null) {
            $port = findFreePort($host);
            if (!$port) {
                echo "Could not find a free port starting from 8000.\n";
                exit;
            }
        } else {
            if (!is_numeric($requestedPort) || $requestedPort < 1 || $requestedPort > 65535) {
                echo "Invalid port: {$requestedPort}\n";
                exit;
            }
            $port = (int)$requestedPort;
            $connection = @fsockopen($host, $port);
            if (is_resource($connection)) {
                fclose($connection);
                echo "Port {$port} is already in use.\n";
                exit;
            }
        }
        
        echo "Starting PHP server at http://{$host}:{$port}\n";
        echo "Press Ctrl+C to stop the server\n\n";
        
        $cmd = "php -S {$host}:{$port} -t {$publicDir}";
        passthru($cmd);
    }
    public static function help()
    {
        echo <<<TEXT

        \033[36mAvailable QuickFrame Commands:\033[0m

        \033[33mserve\033[0m                  Start the built-in PHP development server
        \033[33mserve IP PORT\033[0m          Start server with custom IP and port 
        \033[33mmigrations:on\033[0m          Enable migrations (.env MIGRATIONS_ENABLED=true)
        \033[33mmigrations:off\033[0m         Disable migrations (.env MIGRATIONS_ENABLED=false)
        \033[33m--version\033[0m             Current version of the framework
        \033[33m-v\033[0m                     Shorten command of the version check

        \033[36mmake:\033[0m

        \033[33mcontroller Name\033[0m   Generate a new controller class
        \033[33mmodel Name\033[0m        Generate a new model class
        \033[33mhelper Name\033[0m       Generate a new global helper function
        \033[33mview Name\033[0m         Generate a new view file (Blade-like)
        \033[33mmiddleware Name\033[0m   Generate a new middleware class
        \033[33mmigration Name\033[0m    Generate a new migration class

        

        TEXT;
        echo "\033[36mCLI: frame | Powered by QuickFrame\033[0m\n";
    }
}