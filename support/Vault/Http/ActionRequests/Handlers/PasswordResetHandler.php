<?php

namespace Support\Vault\Http\ActionRequests\Handlers;

use App\Services\Auth\LoginUserService;
use Support\Vault\Http\ActionRequests\ActionRequest;
use Support\Vault\Http\ActionRequests\Services\PasswordResetService;
use Support\Vault\Http\Request;
use Support\Vault\Validation\Exceptions\ValidationException;

class PasswordResetHandler extends ActionRequest
{
    protected PasswordResetService $service;

    public function __construct()
    {
        parent::__construct();
        $this->service = new PasswordResetService();
    }
    
    public function newRequest(String $email, String $userUniqueId)
    {
        $requestData = [
            'email' => $email,
            'user' => $userUniqueId,
            'type' => 'password_reset'
        ];
        return $this->generateRequest($requestData);
    }

    
    public function requestCheck($token) {
        $checkToken = $this->checkUrlToken($token, 'password_reset');
        if(!$checkToken){
            return view('AUTH.passwordReset', [
                'success' => false,
                'message' => 'token not found',
            ]);
        }
        
        $requestData = $this->getRequestData($token, 'password_reset');
        $isUsed = $this->isRequestUsed($requestData->id);
        if(!$isUsed){
            return view('AUTH.passwordReset', [
                'success' => false,
                'message' => 'token already used',
            ]);
        }
        
        //$this->updateRequest($requestData);
        return view('AUTH.passwordReset', [
            'success' => true,
            'email' => $requestData->email,
        ]);
    }

    public function resetPassword(Request $request)
    {
        $data = $request->json();

        try {
            $validatedData = validate($data, [
                'password' => 'required|string|min:6',
            ]);
            $LoginUserService = new LoginUserService;
            $user = $LoginUserService->checkEmail($validatedData['email']);
            if(!$user)
            {
                return response()->json([
                    'status' => false,
                    'message' => 'Account with specified email not found',
                ], 404);
            }
            $result = $this->service->changePassword($validatedData['email'], $validatedData['password']);

            if (!$result) {
                return response()->json([
                    'status' => false,
                    'message' => 'Error ocurrder while processing'
                ], 401);
            }

            return response()->json([
                'status' => true,
                'message' => 'Password changed successfully',
            ]);
        } catch (ValidationException $e) {
            return response()->json(['errors' => $e->errors()], 422);
        }
    }
}