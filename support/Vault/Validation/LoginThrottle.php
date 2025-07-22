<?php

namespace Support\Vault\Validation;

class LoginThrottle
{
    protected static int $maxAttempts = 5;
    protected static int $lockoutTime = 300;

    public static function hit(string $identifier): void
    {
        $key = "login_attempts_$identifier";
        $_SESSION[$key] = ($_SESSION[$key] ?? 0) + 1;
        $_SESSION["{$key}_time"] = time();
    }

    public static function tooManyAttempts(string $identifier): bool
    {
        $key = "login_attempts_$identifier";
        $timeKey = "{$key}_time";

        if (!isset($_SESSION[$key]) || $_SESSION[$key] < self::$maxAttempts) {
            return false;
        }

        $elapsed = time() - ($_SESSION[$timeKey] ?? 0);

        if ($elapsed > self::$lockoutTime) {
            unset($_SESSION[$key], $_SESSION[$timeKey]);
            return false;
        }

        return true;
    }

    public static function clear(string $identifier): void
    {
        unset($_SESSION["login_attempts_$identifier"]);
        unset($_SESSION["login_attempts_{$identifier}_time"]);
    }
}