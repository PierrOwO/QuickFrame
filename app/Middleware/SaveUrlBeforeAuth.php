<?php
namespace App\Middleware;
use Closure;
use Support\Vault\Sanctum\Log;

class SaveUrlBeforeAuth
{
    public function handle($request, Closure $next)
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        if (!isset($_SESSION['user'])) {
            $_SESSION['redirect_after_login'] = $_SERVER['REQUEST_URI'];
            header('Location: /login');
            $url_session = $_SESSION['redirect_after_login'];
            Log::info('SaveUrlBeforeAuth, session:' . $url_session);
            exit;
        }

        return $next($request);
    }
}