<?php

namespace Support\Vault\Foundation\User\Services;

use App\Models\User;
use Support\Vault\Foundation\Hash;

class UserService
{
    public function getUserData(): array
    {
        
        if (!auth()->check())
        {
            return [
                'success' => false,
                'message' => 'user not logged in'
            ];
        }
        $userFirstName = auth()->user()->first_name;
        $userLastName = auth()->user()->last_name;
        $userEmail = auth()->user()->email;

        return [
            'success' => true,
            'userFirstName' => $userFirstName,
            'userLastName' => $userLastName,
            'userEmail' => $userEmail,
        ];
    }
    public function updateEmail($email): bool
    {
        $user = auth()->user();
        $user->email = $email;
        $result = $user->save();
        if (!$result)
        {
            return false;
        }
        auth()->login($user);
        return true;
    }
    public function updatePassword(String $password):bool
    {
        $user = auth()->user();
        $user->password = Hash::make($password);
        $result = $user->save();
        if (!$result)
        {
            return false;
        }
        auth()->login($user);
        return true;
    }
    public function updateFirstName(String $name): bool
    {
        $user = auth()->user();
        $user->first_name = $name;
        $result = $user->save();
        if (!$result)
        {
            return false;
        }
        auth()->login($user);
        return true;
    }
    public function updateLastName(String $name): bool
    {
        $user = auth()->user();
        $user->last_name = $name;
        $result = $user->save();
        if (!$result)
        {
            return false;
        }
        auth()->login($user);
        return true;
    }
    public function deleteUser(): bool
    {
        $user = auth()->user();
        $result = $user->delete();
        if (!$result)
        {
            return false;
        }
        auth()->logout();
        return true;
    }
    public function existsEmail(string $email): bool
    {
        return User::where('email', $email)
            ->first() !== null;
    }
    public function checkOldPassword(String $password): bool
    {
        $user = auth()->user();
        if(!Hash::check($password, $user->password))
        {
            return false;
        }
        return true;
    }
}