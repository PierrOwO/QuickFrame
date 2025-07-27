<?php

namespace App\Services\Auth;
use App\Models\User;
use Support\Vault\Foundation\Hash;
use Support\Vault\Validation\LoginThrottle;

class LoginUserService
{
    public function attempt(string $name, string $password): array
    {
        if (LoginThrottle::tooManyAttempts($name)) {
            return [
                'success' => false,
                'message' => 'Too many login attempts. Try again in a few minutes.'
            ];
        }

        $user = User::where('name', $name)->first();

        if (!$user || !Hash::check($password, $user->password)) {
            LoginThrottle::hit($name);
            return [
                'success' => false,
                'message' => 'Invalid credentials.',
            ];
        }

        LoginThrottle::clear($name);
        auth()->login($user);

        return [
            'success' => true,
            'user' => $user,
        ];
    }
}