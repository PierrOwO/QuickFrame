<?php

namespace App\Services\Auth;

use App\Models\User;
use Support\Vault\Foundation\Hash;
use Support\Vault\Sanctum\Log;

class RegisterUserService
{
    public function register(array $data): User
    {
        $user = new User();
        $user->first_name = $data['first_name'];
        $user->last_name = $data['last_name'];
        $user->name = $data['name'];
        $user->email = $data['email'];
        $user->password = Hash::make($data['password']);
        $user->save();
        return $user;
    }
    public function existsEmail(string $email): bool
    {
        Log::info('email: ' . $email);
        return User::where(['email' => $email])
            ->first() !== null;
    }
    public function existsName(string $name): bool
    {
        Log::info('email: ' . $name);
        return User::where(['name' => $name])
            ->first() !== null;
    }
}