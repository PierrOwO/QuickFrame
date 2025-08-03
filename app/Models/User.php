<?php

namespace App\Models;
use \PDO;
use Support\Vault\Sanctum\Model;

class User extends Model {

    protected static $table = 'users';
    protected static $fillable = [
        'first_name',
        'last_name',
        'name',
        'email',
        'password',
        'unique_id',
    ];
    public function __construct()
    {
        $this->unique_id = self::generateUuid();
    }
    
    public static function findByEmail($email) {
        $stmt = self::db()->prepare("SELECT * FROM users WHERE email = ?");
        $stmt->execute([$email]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public static function authenticate($email, $password) {
        $user = self::findByEmail($email);
        if ($user && password_verify($password, $user['password'])) {
            return $user;
        }
        return null;
    }
    
}