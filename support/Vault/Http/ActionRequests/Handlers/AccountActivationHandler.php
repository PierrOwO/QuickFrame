<?php

namespace Support\Vault\Http\ActionRequests\Handlers;

use Support\Vault\Http\ActionRequests\ActionRequest;
use Support\Vault\Http\ActionRequests\Services\AccountActivationService;
use Support\Vault\Sanctum\Log;

class AccountActivationHandler extends ActionRequest
{ 
    protected AccountActivationService $service;

    public function __construct()
    {
        parent::__construct();
        $this->service = new AccountActivationService;
    }
    public function newRequest(String $email, String $userUniqueId)
    {
        $requestData = [
            'email' => $email,
            'user' => $userUniqueId,
            'type' => 'account_activation'
        ];
        return $this->generateRequest($requestData);
    }

    
    public function accountActivation($token) {
        $checkToken = $this->checkUrlToken($token, 'account_activation');
        if(!$checkToken){
            return response()->json([
                'success' => false,
                'message' => 'token not found'
            ], 404);
        }
        
        $requestData = $this->getRequestData($token, 'account_activation');
        $isUsed = $this->isRequestUsed($requestData->id);
        if(!$isUsed){
            return response()->json([
                'success' => false,
                'message' => 'token already used'
            ], 401);
        }
        $activateUser = $this->service->activateUser($requestData);
        if(!$activateUser){
            return response()->json([
                'success' => false,
                'message' => $activateUser['message']
            ], 401);
        }
        $this->updateRequest($requestData);
        return response()->json([
            'success'=> true,
            'message' => $activateUser['message']
        ]);
    }
    
}