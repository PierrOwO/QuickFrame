<?php

namespace App\Controllers\AUTH;

use App\Services\Auth\LoginUserService;
use Support\Vault\Http\Request;
use Support\Vault\Sanctum\Log;
use Support\Vault\Validation\Exceptions\ValidationException;

class LoginController
{
    protected LoginUserService $loginService;

    public function __construct()
    {
        $this->loginService = new LoginUserService();
    }

    public function index()
    {
        return view('AUTH.login');
    }

    public function login(Request $request)
    {
        $data = $request->json();

        try {
            $validatedData = validate($data, [
                'name' => 'required|string|min:3|max:50',
                'password' => 'required|string|min:6',
            ]);

            $result = $this->loginService->attempt($validatedData['name'], $validatedData['password']);

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