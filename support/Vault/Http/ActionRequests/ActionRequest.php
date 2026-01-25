<?php

namespace Support\Vault\Http\ActionRequests;

use Support\Vault\Http\ActionRequests\Services\ActionRequestService;
use Support\Vault\Sanctum\Log;

class ActionRequest
{
    protected ActionRequestService $actionRequestService;

    public function __construct()
    {
        $this->actionRequestService = new ActionRequestService;
    }
    public function generateRequest($data)
    {
        $generate = $this->actionRequestService->generate($data);
        if (!$generate['success']) {
            return [
                'success' => false,
                'message' => $generate['message']
            ];
        }
        $sendEmail = $this->actionRequestService->sendEmail($data['email'], $generate['token'], $generate['type']);
        Log::info('token: ' .  $generate['token'] . ' || type: ' . $generate['type']);
        if (!$sendEmail['success']) {
            return [
                'success' => false,
                'message' => $sendEmail['message']
            ];
        }
        return [
            'success' => true,
            'message' => $sendEmail['message']
        ];
    }
    public function updateRequest($requestData)
    {
        $this->actionRequestService->updateRequest($requestData);
    }
    public function checkPinToken(String $token, String $type)
    {
        return $this->actionRequestService->checkPinToken($token, $type);
    }
    public function checkUrlToken(String $token, String $type)
    {
        return $this->actionRequestService->checkUrlToken($token, $type);
    }
    public function getRequestData(String $token, String $type)
    {
        return $this->actionRequestService->getRequestData($token, $type);
    }
    public function isRequestUsed(Int $tokenId)
    {   
        return $this->actionRequestService->isRequestUsed($tokenId);
    }
}