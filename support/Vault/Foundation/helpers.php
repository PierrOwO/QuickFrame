<?php

use Support\Vault\Foundation\Config;
use Support\Vault\Http\Response;
use Support\Vault\Sanctum\View;
if (!function_exists('redirect')) {

    function redirect($url)
    {
        header("Location: $url");
        exit();
    }
}
if (!function_exists('view')) {

    function view(string $view, array $data = []) {
        View::render($view, $data);
    }
}
if (!function_exists('asset')) {

    function asset(string $path): string
    {
        $publicPath = __DIR__ . '/../../public/' . ltrim($path, '/');
            
        if (file_exists($publicPath)) {
            $version = filemtime($publicPath);
            return '/' . ltrim($path, '/') . '?v=' . $version;
        }

        return '/' . ltrim($path, '/');
    }
}
function vite(string|array $entries): string
{
    $isDev = env('APP_ENV') === 'development';
    $devServerUrl = env('VITE_DEV_SRV_URL');
    $manifestPath = base_path('public/build/.vite/manifest.json');
    $tags = '';

    if ($isDev && isDevServerRunning()) {
        $entries = (array) $entries;
        foreach ($entries as $entry) {
            $url = $devServerUrl . '/' . ltrim($entry, '/');
            if (str_ends_with($entry, '.js')) {
                $tags .= '<script type="module" src="' . $url . '"></script>' . "\n";
            } elseif (str_ends_with($entry, '.css')) {
                $tags .= '<link rel="stylesheet" href="' . $url . '">' . "\n";
            }
        }
        return $tags;
    }
    else{
        static $manifest = null;
        if ($manifest === null) {
            if (file_exists($manifestPath)) {
                $manifestContent = file_get_contents($manifestPath);
                $manifest = json_decode($manifestContent, true);
            } else {
                $manifest = [];
            }
        }

        $entries = (array) $entries;
        foreach ($entries as $entry) {
            $normalizedEntry = ltrim($entry, '/');
            if (!isset($manifest[$normalizedEntry])) {
                $tags .= '<!-- Nie znaleziono ' . htmlspecialchars($entry) . ' w manifest.json -->' . "\n";
                continue;
            }

            $manifestEntry = $manifest[$normalizedEntry];

            if (isset($manifestEntry['css']) && is_array($manifestEntry['css'])) {
                foreach ($manifestEntry['css'] as $cssFile) {
                    $tags .= '<link rel="stylesheet" href="/build/' . $cssFile . '">' . "\n";
                }
            }

            if (isset($manifestEntry['file'])) {
                $tags .= '<script type="module" src="/build/' . $manifestEntry['file'] . '"></script>' . "\n";
            }
        }

        return $tags;
    }
}
function isDevServerRunning(): bool
{
    $prevHandler = set_error_handler(function(){}); 

    $VITE_DEV_SRV_URL = parse_url(env('VITE_DEV_SRV_URL'));
    $host = $VITE_DEV_SRV_URL['host'] ?? null;   
    $port = $VITE_DEV_SRV_URL['port'] ?? null; 
    $scheme = $VITE_DEV_SRV_URL['scheme'] ?? null;

    try {
        $connection = @fsockopen($host, $port, $errno, $errstr, 0.2);
        if ($connection !== false) {
            fclose($connection);
            if ($prevHandler !== null) {
                set_error_handler($prevHandler);
            } else {
                restore_error_handler();
            }
            return true;
        }
    } catch (Throwable $e) {
        if ($prevHandler !== null) {
            set_error_handler($prevHandler);
        } else {
            restore_error_handler();
        }
    }

    if ($prevHandler !== null) {
        set_error_handler($prevHandler);
    } else {
        restore_error_handler();
    }

    return false;
}


function csrf_token() {
    return $_SESSION['_csrf_token'] ?? 'no csrf token';
}

function csrf_field() {
    $token = htmlspecialchars(csrf_token(), ENT_QUOTES, 'UTF-8');
    return '<input type="hidden" name="_token" value="' . $token . '">';
}
if (!function_exists('base_path')) {
    function base_path($path = '')
    {
        return __DIR__ . '/../../../' . ($path ? '/' . ltrim($path, '/') : '');
    }
}
function response(): Response
{
    return new Response();
}
if (!function_exists('config')) {
    function config(string $key, $default = null) {
        return Config::get($key, $default);
    }
}
function loadConfig(): array {
    $configDir = base_path('config');
    $cacheFile = base_path('storage/cache/config.php');


    $cacheValid = false;
    if (file_exists($cacheFile)) {
        $cacheTime = filemtime($cacheFile);
        $configFiles = glob($configDir . '/*.php');
        $latestConfigTime = 0;
        foreach ($configFiles as $file) {

            $fileTime = filemtime($file);
            if ($fileTime > $latestConfigTime) {
                $latestConfigTime = $fileTime;
            }
        }
        if ($cacheTime !== false && $cacheTime >= $latestConfigTime) {
            $cacheValid = true;
        }
    }

    if ($cacheValid) {
        return include $cacheFile;
    }

    $config = [];
    foreach (glob($configDir . '/*.php') as $file) {

        $key = basename($file, '.php');
        $data = include $file;

        $config[$key] = $data;
    }

    $export = var_export($config, true);
    $content = "<?php\nreturn $export;\n";

    $cacheDir = dirname($cacheFile);
    if (!is_dir($cacheDir)) {
        mkdir($cacheDir, 0755, true);
    }
    file_put_contents($cacheFile, $content);
    return $config;
}