<?php
namespace App\Controllers\AUTH;
use App\Models\User;
use Support\Core\Auth;
use Support\Core\Hash;

class LoginController {

    public function index()
    {
        return view('AUTH.login');
    }
    public function login($name, $password) 
    {
        $user = User::where('name', $name)->first();
        if ($user) {
            $encrypted = $user->password;

            if (Hash::check($password, $encrypted)) {
                Auth::login($user);
                return true; 
            } else {
                return response()->json(['status' => false ,'message' => "Incorrect password!"]);
            }
        } else {
            return response()->json(['status' => false ,'message' => "Cannot find an account with the specified login"]);
        }
    }
}