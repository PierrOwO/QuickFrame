<?php

namespace Support\Core;

use App\Models\User;

class Auth
{
    protected static ?object $cachedUser = null;

    public static function login(object $user): void
    {
        Log::info('wczytano login');
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        session_regenerate_id(true);
        $_SESSION['user_id'] = $user->unique_id; 
        self::$cachedUser = $user;
        Log::info('user: ' . json_encode($user));
        Log::info('sesja: ' . $_SESSION['user_id']);
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
        ini_set('session.cookie_httponly', 1);  
        ini_set('session.cookie_secure', 1);   
    }
}