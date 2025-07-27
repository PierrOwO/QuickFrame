<?php

namespace Support\Vault\Foundation;

use App\Models\User;
use Support\Vault\Sanctum\Log;
use Support\Vault\Foundation\Session;

class Auth
{
    protected static ?object $cachedUser = null;

    public static function login(object $user): void
    {
        Session::start(config('app.session'));

        $csrf = Session::get('_csrf_token');

        session_regenerate_id(true);

        Session::put('_csrf_token', $csrf); 

        Session::put('last_activity', time());
        Session::put('user_id', $user->id);
        Log::info('old csrf: ' . $csrf);
        Log::info('new csrf: ' . Session::get('_csrf_token'));
        Log::info('user: ' . print_r($user, true));
        Log::info('last_activity: ' . Session::get('last_activity'));
        Log::info('user_id: ' . $user->id);
        Log::info('session user_id: ' . Session::get('user_id'));

        self::$cachedUser = $user;
    }

    public static function logout(): void
    {
        Session::start();
        Session::destroy();
        self::$cachedUser = null;
        redirect('/');
    }

    public static function check(): bool
    {
        Session::start();

        if (Session::has('last_activity') && (time() - Session::get('last_activity') > session_timeout())) {
            self::logout();
            return false;
        }

        Session::put('last_activity', time());

        return Session::has('user_id') && self::user() !== null;
    }

    public static function user(): ?object
    {
        Session::start();

        if (self::$cachedUser) {
            return self::$cachedUser;
        }

        if (!Session::has('user_id')) {
            return null;
        }

        $user = User::find(Session::get('user_id'));
        self::$cachedUser = $user;

        return $user;
    }

    public static function secureSession(): void
    {
        //
    }
}