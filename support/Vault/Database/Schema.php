<?php

namespace Support\Vault\Database;

use PDO;
use Support\Core\Log;

class Schema
{
    public static function create(string $table, callable $callback): void
    {
        Schema::ensureMigrationTableExists();

        if (self::hasTable($table)) {
            Log::info('tale exists.');
            throw new \Exception("Table '{$table}' already exists.");
        }

        $blueprint = new Blueprint($table);
        $callback($blueprint);

        $sql = $blueprint->toSql();

        $pdo = Database::connect();
        $pdo->exec($sql);
    }

    public static function dropIfExists(string $table): void
    {
        $sql = "DROP TABLE IF EXISTS `{$table}`;";
        $pdo = Database::connect();
        $pdo->exec($sql);
    }

    public static function hasTable(string $table): bool
    {
        $pdo = Database::connect();
    
        $table = addslashes($table);
        $sql = "SHOW TABLES LIKE '$table'";
    
        $stmt = $pdo->query($sql);
        return $stmt && $stmt->rowCount() > 0;
    }

    public static function ensureMigrationTableExists(): void
    {
        if (!self::hasTable('migrations')) {
            $pdo = Database::connect();
            $sql = "
                CREATE TABLE `migrations` (
                    id INT AUTO_INCREMENT PRIMARY KEY,
                    migration VARCHAR(255) NOT NULL,
                    batch INT NOT NULL,
                    run_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
                );
            ";
            $pdo->exec($sql);
        }
    }

    public static function logMigration(string $migration): void
    {
        $batch = 1;
        $pdo = Database::connect();
        $stmt = $pdo->prepare("INSERT INTO `migrations` (migration, batch) VALUES (:migration, :batch)");
        $stmt->execute([
            'migration' => $migration,
            'batch' => $batch,
        ]);
    }
    public static function removeMigration(string $migration): void
    {
        $pdo = Database::connect();
        $stmt = $pdo->prepare("DELETE FROM `migrations` WHERE `migration` = :migration");
        $stmt->execute(['migration' => $migration]);
    }

    public static function hasRun(string $migration): bool
    {
        $pdo = Database::connect();
        $stmt = $pdo->prepare("SELECT COUNT(*) FROM `migrations` WHERE migration = :migration");
        $stmt->execute(['migration' => $migration]);
        return $stmt->fetchColumn() > 0;
    }

    public static function getNextBatchNumber(): int
    {
        $pdo = Database::connect();
        $result = $pdo->query("SELECT MAX(batch) as max_batch FROM migrations");
        $max = $result->fetch(PDO::FETCH_ASSOC)['max_batch'] ?? 0;
        return $max + 1;
    }
}