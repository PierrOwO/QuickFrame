<?php

namespace App\Services\Auth;
use App\Models\User;
use Support\Vault\Foundation\Hash;
use Support\Vault\Validation\LoginThrottle;

class LoginUserService
{
    public function attempt(string $email, string $password): array
    {
        if (LoginThrottle::tooManyAttempts($email)) {
            return [
                'success' => false,
                'message' => 'Too many login attempts. Try again in a few minutes.'
            ];
        }

        $user = User::where('email', $email)->first();

        if (!$user || !Hash::check($password, $user->password)) {
            LoginThrottle::hit($email);
            return [
                'success' => false,
                'message' => 'Invalid credentials.',
            ];
        }

        LoginThrottle::clear($email);
        auth()->login($user);

        return [
            'success' => true,
            'user' => $user,
        ];
    }
    public function checkEmail(string $email):object
    {
        return User::where('email', $email)
            ->first();
    }
    public function checkIfActivated(object $user):bool
    {
        if($user->activated != 1)
        {
            return false;
        }
        return true;
    }
}