<?php

namespace App\Controllers\AUTH;

use App\Models\User;
use Support\Vault\Foundation\Auth;
use Support\Vault\Foundation\Hash;
use Support\Vault\Validation\LoginThrottle;

class LoginController {

    public function index()
    {
        return view('AUTH.login');
    }
    public function login($name, $password) 
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        if (LoginThrottle::tooManyAttempts($name)) {
            return response()->json([
                'status' => false,
                'message' => 'Too many login attempts. Try again in a few minutes.'
            ]);
        }

        $user = User::where('name', $name)->first();

        if ($user) {
            if (Hash::check($password, $user->password)) {
                LoginThrottle::clear($name); 
                Auth::login($user);
                return true; 
            } else {
                LoginThrottle::hit($name); 
                return response()->json(['status' => false ,'message' => "Incorrect password!"]);
            }
        } else {
            LoginThrottle::hit($name); 
            return response()->json(['status' => false ,'message' => "Cannot find an account with the specified login"]);
        }
    }
}