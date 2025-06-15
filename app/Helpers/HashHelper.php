<?php

namespace App\Helpers;

class HashHelper
{
    public function getHash($password) {

        $salt = sha1(rand());
        $salt = substr($salt, 0, 10);
        $encrypted = password_hash($password.$salt, PASSWORD_DEFAULT);
        $hash = array("salt" => $salt, "encrypted" => $encrypted);
   
        return $hash;
   
   }
    public function verifyHash($password, $hash) {
        
        return password_verify($password, $hash);
    }
}