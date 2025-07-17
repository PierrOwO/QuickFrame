<?php

namespace Support\Vault\Foundation;

class Hash
{
    public static function make(string $value, array $options = []): string
    {
        return password_hash($value, PASSWORD_BCRYPT, $options);
    }

    public static function check(string $value, string $hashedValue): bool
    {
        return password_verify($value, $hashedValue);
    }

    public static function needsRehash(string $hashedValue, array $options = []): bool
    {
        return password_needs_rehash($hashedValue, PASSWORD_BCRYPT, $options);
    }
}