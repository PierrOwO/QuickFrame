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
    case 'ftp:init':
        GitFtp::init();
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
        echo CliHandlerFunctions::serve();
        break;
    case '/help':
        echo CliHandlerFunctions::help();
        break;
        
    default:
        echo "unknown command\n";
        echo "check available commends: /help\n";
}
