<?php

namespace Support\Vault\Http\ActionRequests\Services;

use App\Models\User;

class EmailVerificationService
{
    public function verifyEmail($requestData):array{
        $update = User::where('unique_id', $requestData->user)->first();
        $update->verified_email = 1;
        $result = $update->save();
        if (!$result){
            return [
                'success' => false,
                'message' => 'Error while processing'
            ];
        }
        return [
            'success' => true,
            'message' => 'User email verified successfully'
        ];
    }
}
