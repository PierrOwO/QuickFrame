<?php

namespace Support\Vault\Foundation;

use Support\Vault\Sanctum\Log;

class Session
{
    protected static bool $started = false;

    public static function start(array $params = []): void
    {
        
        if (self::$started) {
            return;
        }

        if (empty($params)) {
            $params = config('app.session');
        }

        if (session_status() === PHP_SESSION_NONE) {
            if (PHP_VERSION_ID >= 70300) {
                session_set_cookie_params([
                    'lifetime' => $params['lifetime'] ?? 0,
                    'path'     => $params['path']     ?? '/',
                    'domain'   => $params['domain']   ?? '',
                    'secure'   => $params['secure']   ?? true,
                    'httponly' => $params['httponly'] ?? true,
                    'samesite' => $params['samesite'] ?? 'Strict',
                ]);
            } else {
                ini_set('session.cookie_httponly', $params['httponly'] ?? 1);
                ini_set('session.cookie_secure', $params['secure'] ?? 1);
                ini_set('session.cookie_path', ($params['path'] ?? '/') . '; samesite=' . ($params['samesite'] ?? 'Strict'));
            }

            session_start();
            self::$started = true;
            Log::debug('Session start', [
                'started' => Session::$started,
                'status' => session_status(),
                'session_id' => session_id(),
                '_SESSION' => $_SESSION,
            ]);
        }
    }

    public static function put(string $key, mixed $value): void
    {
        self::ensureStarted();
        $_SESSION[$key] = $value;
    }

    public static function get(string $key, mixed $default = null): mixed
    {
        self::ensureStarted();
        return $_SESSION[$key] ?? $default;
    }

    public static function has(string $key): bool
    {
        self::ensureStarted();
        return isset($_SESSION[$key]);
    }

    public static function forget(string $key): void
    {
        self::ensureStarted();
        unset($_SESSION[$key]);
    }

    public static function all(): array
    {
        self::ensureStarted();
        return $_SESSION;
    }

    public static function destroy(): void
    {
        self::ensureStarted();
        $_SESSION = [];
        session_destroy();
        self::$started = false;
    }

    protected static function ensureStarted(): void
    {
        if (!self::$started || session_status() === PHP_SESSION_NONE) {
            self::start();
        }
    }
    public static function flash(string $key, mixed $value): void {
        self::put('_flash.' . $key, $value);
    }
    public static function getFlash(string $key, mixed $default = null): mixed {
        $full = '_flash.' . $key;
        $val = self::get($full, $default);
        self::forget($full);
        return $val;
    }
    public static function csrf(): string
    {
        self::ensureStarted();

        if (!isset($_SESSION['_csrf_token'])) {
            $_SESSION['_csrf_token'] = bin2hex(random_bytes(32));
        }

        return $_SESSION['_csrf_token'];
    }
}