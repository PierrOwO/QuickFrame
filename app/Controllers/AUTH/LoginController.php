<?php

namespace App\Controllers\AUTH;

use App\Services\Auth\LoginUserService;
use Carbon\Carbon;
use Support\Vault\Http\Request;
use Support\Vault\Sanctum\Log;
use Support\Vault\Validation\Exceptions\ValidationException;

class LoginController
{
    protected LoginUserService $service;

    public function __construct()
    {
        $this->service = new LoginUserService();
    }

    public function index()
    {
        //return view('AUTH.login');
        return vueView('login', [
            'title' => 'Login page',
            'year' => Carbon::now()->format('Y'),
        ]);    }

    public function login(Request $request)
    {
        $data = $request->json();

        try {
            $validatedData = validate($data, [
                'email' => 'required|email',
                'password' => 'required|string|min:6',
            ]);
            $user = $this->service->checkEmail($validatedData['email']);
            if(!$user)
            {
                return response()->json([
                    'status' => false,
                    'message' => 'Account with specified email not found',
                ], 404);
            }
            if(config('app.env') == 'production')
            {
                $activated = $this->service->checkIfActivated($user);
                if (!$activated)
                {
                    return response()->json([
                        'status' => false,
                        'message' => 'Account not activated yet.',
                    ], 401);
                }
            }
            
            $result = $this->service->attempt($validatedData['email'], $validatedData['password']);

            if (!$result['success']) {
                return response()->json([
                    'status' => false,
                    'message' => $result['message'],
                ], 401);
            }

            return response()->json([
                'status' => true,
                'message' => 'Login successful',
            ]);
        } catch (ValidationException $e) {
            return response()->json(['errors' => $e->errors()], 422);
        }
    }
}