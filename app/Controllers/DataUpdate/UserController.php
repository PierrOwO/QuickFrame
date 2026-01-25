<?php

namespace App\Controllers\DataUpdate;

use App\Services\DataUpdate\UserService;
use Support\Vault\Http\Request;
use Support\Vault\Validation\Exceptions\ValidationException;

class UserController
{
    protected UserService $service;

    public function __construct() {
        $this->service = new UserService();
    }

    public function index()
    {
        return vueView('userData', [
            'title' => 'User data',
        ]);
    }
    public function newEmailRequest(Request $request)
    {
        $data = $request->json();

        try {
            $validatedData = validate($data, [
                'email' => 'required|email',
            ]);
            $errors = [];
            if ($this->service->existsEmail($data['email'])) {
                $errors['email'] = 'Email is already registered.';
            }
            if (!empty($errors)) {
                return response()->json(['errors' => $errors], 422);
            }

            $result = $this->service->newEmailRequest($validatedData['email']);
            if(!$result['success'])
            {
                return response()->json([
                    'success' => false,
                    'message' => $result['message']
                ], 500);
            }
            return response()->json([
                'success' => true,
                'message' => 'Token sent to your e-mail address'
            ]);

        } catch (ValidationException $e) {
            return response()->json(['errors' => $e->errors()], 422);
        }
    }
    public function updateDataFromRequest(string $token)
    {
        return $this->service->updateDataFromRequest($token);   
    }
}