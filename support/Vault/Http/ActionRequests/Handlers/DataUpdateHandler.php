<?php

namespace Support\Vault\Http\ActionRequests\Handlers;

use Support\Vault\Database\DB;
use Support\Vault\Http\ActionRequests\ActionRequest;
use Support\Vault\Http\ActionRequests\Helpers\DataUpdate;
use Support\Vault\Http\ActionRequests\Services\DataUpdateService;
use Support\Vault\Sanctum\Log;

class DataUpdateHandler extends ActionRequest
{
    protected DataUpdateService $service;

    public function __construct()
    {
        parent::__construct();
        $this->service = new DataUpdateService;
    }
    public function create(string $table, string $action, array $where, array $data) {
        $payload = [
            [
                'table' => $table,
                'action' => $action,
                'where' => $where,
                'data' => $data,
            ],
        ];
        return $this->newRequest(auth()->user()->email, auth()->user()->unique_id, $payload);
    }
    public function newRequest(String $email, String $userUniqueId, Array $payload)
    {
        
        $requestData = [
            'email' => $email,
            'user' => $userUniqueId,
            'payload' => $payload, 
            'type' => 'data_update'
        ];
        return $this->generateRequest($requestData);
    }
    public function updateData(String $token)
    {
        $requestExists = $this->checkPinToken($token, 'data_update');
        if(!$requestExists)
        {
            return response()->json([
                'success' => false,
                'message'=> "Token used or doesn't exists."
            ], 401);
        }
        $requestData = $this->getRequestData($token, 'data_update');
        $payload = json_decode($requestData->payload, true);
        $this->service->handle($payload, $requestData->user);
        $this->updateRequest($requestData);
        
        return response()->json([
            'success' => true,
            'message'=> "Data updated successfully!"
        ]);
    }
    
}