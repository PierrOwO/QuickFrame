<?php

namespace Support\Vault\Http\ActionRequests\Handlers;

use Support\Vault\Http\ActionRequests\ActionRequest;
use Support\Vault\Http\ActionRequests\Services\EmailVerificationService;
 
class EmailVerificationHandler extends ActionRequest
{ 
    protected EmailVerificationService $service;

    public function __construct()
    {
        parent::__construct();
        $this->service = new EmailVerificationService;
    }
    public function newRequest(String $email, String $userUniqueId)
    {
        $requestData = [
            'email' => $email,
            'user' => $userUniqueId,
            'type' => 'email_verification'
        ];
        return $this->generateRequest($requestData);
    }

    public function emailVerification($token) {
        $checkToken = $this->checkUrlToken($token, 'account_activation');
        if(!$checkToken){
            return [
                'success' => false,
                'message' => 'token not found'
            ];
        }
        $requestData = $this->getRequestData($token, 'account_activation');
        $isUsed = $this->isRequestUsed($requestData->id);
        if(!$isUsed){
            return [
                'success' => false,
                'message' => 'token already used'
            ];
        }
        $verify = $this->service->verifyEmail($requestData);
        if(!$verify('success')){
            return [
                'success' => false,
                'message' => $verify['message']
            ];
        }
        $this->updateRequest($requestData);
        return [
            'success'=> true,
            'message' => $verify['message']
        ];
    }
}