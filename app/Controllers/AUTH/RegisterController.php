<?php

namespace App\Controllers\AUTH;

use App\Services\Auth\RegisterUserService;
use Carbon\Carbon;
use Support\Vault\Http\ActionRequests\ActionRequest;
use Support\Vault\Http\ActionRequests\Handlers\AccountActivationHandler;
use Support\Vault\Http\Request;
use Support\Vault\Sanctum\Log;
use Support\Vault\Validation\Exceptions\ValidationException;

class RegisterController 
{
    protected RegisterUserService $service;

    public function __construct()
    {
        $this->service = new RegisterUserService();
    }

    public function index()
    {
        //return view('AUTH.register');
        return vueView('register', [
            'title' => 'Register page',
            'year' => Carbon::now()->format('Y'),
        ]);

    }

    public function register(Request $request)
    {
        $data = $request->json();
        try {
            $validatedData = validate($data, [
                'first_name' => 'required|alpha_dash|min:3|max:50',
                'last_name' => 'required|alpha_dash|min:3|max:50',
                'email' => 'required|email',
                'password' => 'required|min:6|confirmed',
            ]);

            $errors = [];
            if ($this->service->existsEmail($data['email'])) {
                $errors['email'] = 'Email is already registered.';
            }
            if (!empty($errors)) {
                return response()->json(['errors' => $errors], 422);
            }

            $registerUser = $this->service->register($validatedData);
            if (!$registerUser) {
                return response()->json([
                    'success' => false,
                    'message' => 'error while processing'
                ], 500);
            }
            if(config('app.env') == 'production')
            {
                $AccountActivationHandler = new AccountActivationHandler;
                $AccountActivationHandler->newRequest($registerUser->email, $registerUser->unique_id);
                if (request()->expectsJson()) {
                    return response()->json(['message' => 'Success, an activation email sent!']);
                }
                
            }
            
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