<?php

use Support\Vault\Config\CliHandlerFunctions;
use Support\Vault\Config\Framework;
use Support\Vault\Creation\CreationHandler;
use Support\Vault\FTP\GitFtp;
require __DIR__ . '/autoload.php';

$argv = $_SERVER['argv'];
$command = $argv[1] ?? null;

switch ($command) {
    case 'ftp:push':
        GitFtp::push();
        break;
    case 'cache:clear':
        $type = $argv[2] ?? 'all';

        if ($type === 'all') {
            echo CliHandlerFunctions::clearCache('config');
            echo CliHandlerFunctions::clearCache('routes');
            echo CliHandlerFunctions::clearCache('views');
            echo "All cache cleared\n";
        } elseif (in_array($type, ['routes', 'views'])) {
            echo CliHandlerFunctions::clearCache($type);
            echo ucfirst($type) . " cache cleared\n";
        } else {
            echo "Unknown cache type\n";
        }
        break;

    case 'cache:routes':
        CliHandlerFunctions::cacheRoutes();
        break;

    case 'cache:views':
        CliHandlerFunctions::cacheViews();
        break;
    case 'cache:config':
        CliHandlerFunctions::cacheConfig();
        echo "Config cached successfully!\n";
        break;
    case 'cache:all':
        CliHandlerFunctions::cacheConfig();
        CliHandlerFunctions::cacheRoutes();
        CliHandlerFunctions::cacheViews();
        echo "All caches generated\n";
        break;
    case 'run:test':
        echo "Running tests...\n";
        exec('php support/Tools/phpunit.phar support/Tests', $output) ;
        echo implode("\n", $output);
        break;
    case '--version':
        echo "\033[36mQuickFrame version: \033[35m" . Framework::version() . "\033[0m\n";
        break;
    case '-v':
        echo "\033[36mQuickFrame version: \033[35m" . Framework::version() . "\033[0m\n";
        break;
    case 'make:test':
        $name = $argv[2] ?? null;
        echo CreationHandler::createtest($name);
        break;
    case 'make:controller':
        $name = $argv[2] ?? null;
        echo CreationHandler::createController($name);
        break;
    case 'make:model':
        $name = $argv[2] ?? null;
        echo CreationHandler::createModel($name);
        break;
    case 'make:middleware':
        $name = $argv[2] ?? null;
        echo CreationHandler::createMiddleware($name);
        break;
    case 'make:helper':
        $name = $argv[2] ?? null;
        echo CreationHandler::createHelper($name);
        break;
    case 'make:view':
        $name = $argv[2] ?? null;
        echo CreationHandler::createView($name);
        break;
    case 'make:migration':
        $name = $argv[2] ?? null;
        echo CreationHandler::createMigration($name);
        break;
    case 'migrations:on':
        CliHandlerFunctions::updateEnvValue('MIGRATIONS_ENABLED', 'true');
        echo "Migrations enabled.\n";
        echo "You can now access the migration panel at /migrations.\n";
        break;
    case 'migrations:off':
        CliHandlerFunctions::updateEnvValue('MIGRATIONS_ENABLED', 'false');
        echo "Migrations disabled.\n";
        break;
    case 'serve':
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
        break;
    case '/help':
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
        break;
        
    default:
        echo "unknown command\n";
        echo "check available commends: /help\n";
}
