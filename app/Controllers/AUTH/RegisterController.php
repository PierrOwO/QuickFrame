<?php

namespace App\Controllers\AUTH;

use Support\Vault\Http\Request;
use Support\Vault\Validation\Exceptions\ValidationException;

class RegisterController 
{
    public function index()
    {
        return view('AUTH.register');
    }
    public function register(Request $request)
    {
        try {
            $validatedData = validate($request->all(), [
                'name' => 'required|alpha_dash|min:3|max:50',
                'email' => 'required|email',
                'password' => 'required|min:6|confirmed',
                'age' => 'nullable|integer|min:18',
            ]);
    
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
                'old' => $request->all()
            ]);
        }
    }
}