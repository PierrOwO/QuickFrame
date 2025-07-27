<?php

namespace App\Controllers\AUTH;

use App\Services\Auth\RegisterUserService;
use Support\Vault\Http\Request;
use Support\Vault\Sanctum\Log;
use Support\Vault\Validation\Exceptions\ValidationException;

class RegisterController 
{
    protected RegisterUserService $userService;

    public function __construct()
    {
        $this->userService = new RegisterUserService();
    }

    public function index()
    {
        return view('AUTH.register');
    }

    public function register(Request $request)
    {
        $data = $request->json();
        try {
            $validatedData = validate($data, [
                'first_name' => 'required|alpha_dash|min:3|max:50',
                'last_name' => 'required|alpha_dash|min:3|max:50',
                'name' => 'required|alpha_dash|min:3|max:50',
                'email' => 'required|email',
                'password' => 'required|min:6|confirmed',
            ]);

            $errors = [];
            if ($this->userService->existsName($data['name'])) {
                $errors['name'] = 'Name is already taken.';
            }
            if ($this->userService->existsEmail($data['email'])) {
                $errors['email'] = 'Email is already registered.';
            }
            if (!empty($errors)) {
                return response()->json(['errors' => $errors], 422);
            }

            $this->userService->register($validatedData);
            if (request()->expectsJson()) {
                return response()->json(['message' => 'Registration successful!']);
            }
            

            echo "Registration successful!";
    
        } catch (ValidationException $e) {
            if (request()->expectsJson()) {
                return response()->json(['errors' => $e->errors()], 422);
            }
    
            return view('AUTH.register', [
                'errors' => $e->errors(),
                'old' => $request->json()
            ]);
        }
    }
}