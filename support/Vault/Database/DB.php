<?php

namespace Support\Vault\Database;

use PDO;
use PDOException;

/**
 * Class DB
 *
 * A simple mini-ORM / query builder for database operations.
 * Inherits from Database (PDO connection).
 * Supports basic CRUD: insert, update, delete, select (get).
 */
class DB extends Database
{
    /** @var string The table name to operate on */
    protected static string $table;

    /** @var array The WHERE conditions for queries */
    protected array $wheres = [];

    /**
     * Constructor
     *
     * Initializes PDO connection from the parent Database class.
     */
    public function __construct()
    {
        self::$pdo = self::connect();
    }

    /**
     * Selects the table to operate on.
     *
     * @param string $tableName The table name
     * @return self
     */
    public static function table(string $tableName): self
    {
        $instance = new self();
        self::$table = $tableName;
        return $instance;
    }

    /**
     * Sets WHERE conditions for the query.
     *
     * Example: ->where(['id' => 5, 'status' => 'active'])
     *
     * @param array $wheresData Key-value pairs of column => value
     * @return self
     */
    public function where(array $wheresData): self
    {
        $this->wheres = [];
        foreach ($wheresData as $column => $value) {
            $this->wheres[] = [
                'column' => $column,
                'operator' => '=', // default operator, can be extended
                'value' => $value,
            ];
        }
        return $this;
    }

    /**
     * Builds the WHERE clause for the query.
     *
     * @param array $params Reference to array that will contain PDO values
     * @return string The WHERE SQL clause
     */
    protected function buildWhere(array &$params): string
    {
        if (empty($this->wheres)) return '';

        $conditions = [];
        foreach ($this->wheres as $where) {
            $conditions[] = "`{$where['column']}` {$where['operator']} ?";
            $params[] = $where['value'];
        }

        return 'WHERE ' . implode(' AND ', $conditions);
    }

    /**
     * Executes INSERT, UPDATE, or DELETE queries.
     *
     * @param string $sql The SQL query
     * @param array $params Parameters for prepared statement
     * @return bool Success
     * @throws PDOException
     */
    protected function execute(string $sql, array $params): bool
    {
        try {
            $stmt = self::$pdo->prepare($sql);
            return $stmt->execute($params);
        } catch (PDOException $e) {
            throw $e;
        }
    }

    /**
     * Executes a SELECT query and returns results.
     *
     * @param string $sql The SQL query
     * @param array $params Parameters for prepared statement
     * @return array The result set
     */
    protected function query(string $sql, array $params): array
    {
        $stmt = self::$pdo->prepare($sql);
        $stmt->execute($params);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Updates rows in the table based on WHERE conditions.
     *
     * Example:
     * DB::table('users')->where(['id' => 5])->update(['first_name' => 'John']);
     *
     * @param array $data Column => value pairs to update
     * @return bool Success
     * @throws \Exception If WHERE conditions are empty
     */
    public function update(array $data): bool
    {
        if (empty($this->wheres)) {
            throw new \Exception('UPDATE without WHERE is not allowed!');
        }

        $set = [];
        $params = [];
        foreach ($data as $column => $value) {
            $set[] = "`$column` = ?";
            $params[] = $value;
        }

        $whereSql = $this->buildWhere($params);

        $sql = sprintf(
            "UPDATE `%s` SET %s %s",
            self::$table,
            implode(', ', $set),
            $whereSql
        );

        return $this->execute($sql, $params);
    }

    /**
     * Inserts a new row into the table.
     *
     * Example:
     * DB::table('users')->insert(['first_name' => 'John', 'last_name' => 'Doe']);
     *
     * @param array $data Column => value pairs to insert
     * @return bool Success
     */
    public function insert(array $data): bool
    {
        $columns = array_keys($data);
        $placeholders = array_fill(0, count($columns), '?');

        $sql = sprintf(
            "INSERT INTO `%s` (%s) VALUES (%s)",
            self::$table,
            implode(', ', $columns),
            implode(', ', $placeholders)
        );

        return $this->execute($sql, array_values($data));
    }

    /**
     * Deletes rows from the table based on WHERE conditions.
     *
     * Example:
     * DB::table('users')->where(['id' => 5])->delete();
     *
     * @return bool Success
     * @throws \Exception If WHERE conditions are empty
     */
    public function delete(): bool
    {
        if (empty($this->wheres)) {
            throw new \Exception('DELETE without WHERE is not allowed!');
        }

        $params = [];
        $whereSql = $this->buildWhere($params);

        $sql = sprintf(
            "DELETE FROM `%s` %s",
            self::$table,
            $whereSql
        );

        return $this->execute($sql, $params);
    }

    /**
     * Selects rows from the table based on WHERE conditions.
     *
     * Example:
     * $users = DB::table('users')->where(['status' => 'active'])->get();
     *
     * @return array The result set
     */
    public function get(): array
    {
        $params = [];
        $whereSql = $this->buildWhere($params);

        $sql = sprintf(
            "SELECT * FROM `%s` %s",
            self::$table,
            $whereSql
        );

        return $this->query($sql, $params);
    }
}