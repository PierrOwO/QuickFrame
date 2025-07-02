<?php
namespace App\Controllers\AUTH;
use App\Models\User;
use Support\Core\Auth;
use App\Helpers\HashHelper;
class LoginController {

    public function index(){
        return view('AUTH.login');
    }
    public function login($name, $password) {
        $user = User::where('name', $name)->first();
        if($user)
        {
            $hashHelper = new HashHelper;
            $salt = $user->sn;
            $db_encrypted_password = $user->password;
            $hashHelper = new HashHelper();
            $isValid = $hashHelper->verifyHash($password.$salt,$db_encrypted_password);
            if($isValid){
                Auth::login($user);
            } else {
                return "Incorrect password!";
            }
        } else {
            return "Cannot find an account with the specified login";
        }
    }
}