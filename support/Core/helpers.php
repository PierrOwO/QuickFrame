<?php

use Support\Core\Http\Response;
use Support\Core\View;

function redirect($url)
{
    header("Location: $url");
    exit();
}
function view(string $view, array $data = []) {
    View::render($view, $data);
}
function asset(string $path): string
{
    $publicPath = __DIR__ . '/../../public/' . ltrim($path, '/');
        
    if (file_exists($publicPath)) {
        $version = filemtime($publicPath);
        return '/' . ltrim($path, '/') . '?v=' . $version;
    }

    return '/' . ltrim($path, '/');
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
        return __DIR__ . '/../../' . ($path ? '/' . ltrim($path, '/') : '');
    }
}
function response(): Response
{
    return new Response();
}