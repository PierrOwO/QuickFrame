<?php

namespace Support\Vault\Foundation\User\Controllers;

use Support\Vault\Foundation\User\Services\UserService;
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
        $result = $this->service->getUserData();
        if(!$result['success']){
            return response()->json([
                'success' => false,
                'message' => $result['message']
            ], 500);
        }
        return response()->json([
            'success' => true,
            'userFirstName' => $result['userFirstName'],
            'userLastName' => $result['userLastName'],
        ]);
    }

    public function updateEmail(Request $request)
    {
        $data = $request->json();
        try {
            $validatedData = validate($data, [
                'email' => 'required|email',
            ]);
            $errors = [];

            if ($this->service->existsEmail($validatedData['email'])) {
                $errors['email'] = 'Email is already registered.';
            }
            if (!empty($errors)) {
                return response()->json(['errors' => $errors], 422);
            }
            if (!$this->service->updateEmail($validatedData['email'])) {
                return response()->json([
                    'success' => false,
                    'message' => 'An error occurred while processing'
                ], 500);
            }
            return response()->json([
                'success' => true,
                'message' => 'Email updated successfully'
            ]);
        }
        catch(ValidationException $e) {
            return response()->json([
                'errors' => $e->errors()
            ], 422);

        }
    }

    public function updatePassword(Request $request)
    {
        $data = $request->json();
    
        try {
            $validatedData = validate($data, [
                'old_password' => 'required',
                'password' => 'required|min:6|confirmed',
            ]);
            
            if (!$this->service->checkOldPassword($validatedData['old_password'])) {
                return response()->json([
                    'success' => false,
                    'message' => 'Wrong old password'
                ], 400);
            }
    
            $updated = $this->service->updatePassword($validatedData['password']);
    
            if (!$updated) {
                return response()->json([
                    'success' => false,
                    'message' => 'An error occurred while processing'
                ], 500);
            }
    
            return response()->json([
                'success' => true,
                'message' => 'Password updated successfully!'
            ]);
        }
        catch (ValidationException $e) {
            return response()->json([
                'errors' => $e->errors()
            ], 422);
        }
    }

    public function updateFirstName(Request $request)
    {
        $data = $request->json();
        try {
            $validatedData = validate($data, [
                'first_name' => 'required|string|min:3|max:50',
            ]);
            
            if (!$this->service->updateFirstName($validatedData['first_name'])) {
                return response()->json([
                    'success' => false,
                    'message' => 'An error occurred while processing'
                ], 500);
            }
            return response()->json([
                'success' => true,
                'message' => 'First name updated successfully'
            ]);
        }
        catch(ValidationException $e) {
            return response()->json([
                'errors' => $e->errors()
            ], 422);

        }
    }

    public function updateLastName(Request $request)
    {
        $data = $request->json();
        try {
            $validatedData = validate($data, [
                'last_name' => 'required|string|min:3|max:50',
            ]);
            
            if (!$this->service->updateLastName($validatedData['last_name'])) {
                return response()->json([
                    'success' => false,
                    'message' => 'An error occurred while processing'
                ], 500);
            }
            return response()->json([
                'success' => true,
                'message' => 'Last name updated successfully'
            ]);
        }
        catch(ValidationException $e) {
            return response()->json([
                'errors' => $e->errors()
            ], 422);

        }
    }

    public function destroy()
    {
        $result = $this->service->deleteUser();
        if(!$result)
        {
            return response()->json([
                'success' => false,
                'message' => 'An error occured while processing'
            ]);
        }
        return true;
    }
}