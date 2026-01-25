<?php

namespace Support\Vault\Http\ActionRequests\Services;

use App\Models\User;
use Carbon\Carbon;

class AccountActivationService
{
    public function activateUser($requestData):array{
        $update = User::where('unique_id', $requestData->user)->first();
        $update->activated = 1;
        $update->activated_at = Carbon::now();
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
            'message' => 'User activated successfully'
        ];
    }
}