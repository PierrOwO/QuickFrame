<?php 
namespace Support\Vault\Database;

use PDO;
use PDOException;

class Database
{
    protected static ?PDO $pdo = null;

    public static function connect(): PDO
    {
        if (self::$pdo === null) {
            
            $config = config('database.connections.mysql');

            $host = $config['host'];
            $db = $config['database'];
            $user = $config['username'];
            $pass = $config['password'];
            $charset = $config['charset'];

            $dsn = "mysql:host=$host;dbname=$db;charset=$charset";
            $options = [
                PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                PDO::ATTR_EMULATE_PREPARES   => false,
            ];

            try {
                self::$pdo = new PDO($dsn, $user, $pass, $options);
            } catch (PDOException $e) {
                throw new \RuntimeException("DB connection failed: " . $e->getMessage());
            }
        }
        return self::$pdo;
    }
}