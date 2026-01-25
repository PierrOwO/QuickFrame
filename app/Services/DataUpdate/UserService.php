<?php

namespace App\Services\DataUpdate;

use App\Models\User;
use Support\Vault\Foundation\Hash;
use Support\Vault\Http\ActionRequests\Handlers\DataUpdateHandler;
use Support\Vault\Http\ActionRequests\Helpers\DataUpdate;

class UserService
{
    private function sendRequest(array $data)
    {
        $where = [
            'id' => auth()->user()->id,
        ];
        return DataUpdate::table('users')
                    ->action('update')
                    ->where($where)
                    ->data($data)
                    ->create();
        
    }
    public function updateDataFromRequest (string $token)
    {
       $DataUpdateHandler = new DataUpdateHandler;
       return $DataUpdateHandler->updateData($token);
    }
    public function existsEmail(string $email): bool
    {
        return User::where('email', $email)
            ->first() !== null;
    }
    public function newEmailRequest(string $email) {
        $data = [
            'email' => $email,
        ];
        return $this->sendRequest($data);
    }
    public function newPasswordRequest(string $password) {
        $hashed = Hash::make($password);
        $data = [
            'password' => $hashed,
        ];
        return $this->sendRequest($data);
    }
    public function newNames(string $firstName, string $lastName)
    {
        $user = auth()->user();
        $user->first_name = $firstName;
        $user->last_name = $lastName;
        
        return $user->save();
    }
}