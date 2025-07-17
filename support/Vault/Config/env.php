<?php
function env($key, $default = null) {
    static $vars;

    if (!$vars) {
        $lines = file(__DIR__ . '/../../../.env', FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
        foreach ($lines as $line) {
            if (str_starts_with(trim($line), '#')) continue;
            list($name, $value) = explode('=', $line, 2);
            $vars[trim($name)] = trim($value);
        }
    }

    return $vars[$key] ?? $default;
}
