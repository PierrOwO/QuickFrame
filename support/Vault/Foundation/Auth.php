<?php

namespace Support\Vault\Foundation;

use App\Models\User;
use Support\Vault\Sanctum\Log;

class Auth
{
    protected static ?object $cachedUser = null;

    public static function login(object $user): void
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        session_regenerate_id(true);
        $_SESSION['last_activity'] = time();
        $_SESSION['user_id'] = $user->unique_id; 
        self::$cachedUser = $user;
        Log::info('user: ' . json_encode($user));
        Log::info('session: ' . $_SESSION['user_id']);
    }

    public static function logout(): void
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        $_SESSION = [];
        session_destroy();
        self::$cachedUser = null;
        redirect('/');
    }

    public static function check(): bool
{
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }

    $timeout = config('app.session_timeout');

    if (isset($_SESSION['last_activity']) && (time() - $_SESSION['last_activity'] > $timeout)) {
        self::logout();
        return false;
    }

    $_SESSION['last_activity'] = time();

    return isset($_SESSION['user_id']) && self::user() !== null;
}

    public static function user(): ?object
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        if (self::$cachedUser) {
            return self::$cachedUser;
        }

        if (!isset($_SESSION['user_id'])) {
            return null;
        }

        $user = User::find($_SESSION['user_id']);
        self::$cachedUser = $user;

        return $user;
    }

    public static function secureSession(): void
{
    if (PHP_VERSION_ID >= 70300) {
        session_set_cookie_params([
            'lifetime' => 0,
            'path' => '/',
            'domain' => '',
            'secure' => true, 
            'httponly' => true,
            'samesite' => 'Strict' 
        ]);
    } else {
        ini_set('session.cookie_httponly', 1);
        ini_set('session.cookie_secure', 1);
        ini_set('session.cookie_path', '/; samesite=Strict');
    }

    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }
}
}