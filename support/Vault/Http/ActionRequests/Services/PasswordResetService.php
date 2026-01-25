<?php

namespace Support\Vault\Http\ActionRequests\Services;

use App\Models\User;
use Support\Vault\Foundation\Hash;

class PasswordResetService
{
    public function changePassword (string $email, string $password): bool
    {
        $user = User::where('email', $email)->first();
        $user->password = Hash::make($password);
        if(!$user->save())
        {
            return false;
        }
        return true;

    }
}
