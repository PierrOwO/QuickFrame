<?php
namespace Support\Vault\Database;

use PDO;

abstract class Seeder
{
    protected static ?PDO $pdo = null;

    public static function pdo(): PDO
    {
        if (self::$pdo === null) {
            self::$pdo = Database::connect();
        }
        return self::$pdo;
    }

    abstract public static function run(): void;
}