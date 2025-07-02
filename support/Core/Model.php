<?php

namespace Support\Core;

use \PDO;

class Model {
    protected static $table;
    protected static $connection;
    protected static $fillable = [];

    protected $attributes = [];
    protected $conditions = [];
    protected $order = '';


    public function __construct(array $attributes = [])
    {
        // Przypisz wszystkie przekazane atrybuty do właściwości $attributes
        $this->attributes = $attributes;

        foreach ($attributes as $key => $value) {
            $this->$key = $value;
        }
    }
    public static function db() 
    {
        if (!self::$connection) {
            $host = env('DB_HOST');
            $dbname = env('DB_NAME');
            $user = env('DB_USER');
            $pass = env('DB_PASSWORD');

            $dsn = "mysql:host=$host;dbname=$dbname;charset=utf8mb4";
            self::$connection = new PDO($dsn, $user, $pass);
            self::$connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        }

        return self::$connection;
    }

    public function __get($key) {
        return $this->attributes[$key] ?? null;
    }

    public function __set($key, $value) {
        $this->attributes[$key] = $value;
    }

    public function fill(array $data) 
    {
        foreach (static::$fillable as $field) {
            if (array_key_exists($field, $data)) {
                $this->attributes[$field] = $data[$field];
            }
        }
        return $this;
    }

    public function toArray() 
    {
        return $this->attributes;
    }

    public function save() 
    {
        $table = static::$table;
        $fillable = static::$fillable;

        $data = array_filter(
            $this->attributes,
            fn($key) => in_array($key, $fillable),
            ARRAY_FILTER_USE_KEY
        );

        if (isset($this->attributes['id'])) {
            $id = $this->attributes['id'];
            unset($data['id']);

            $set = implode(', ', array_map(fn($key) => "$key = ?", array_keys($data)));
            $values = array_values($data);
            $values[] = $id;

            $sql = "UPDATE $table SET $set WHERE id = ?";
            $stmt = self::db()->prepare($sql);
            $stmt->execute($values);

            return self::find($id);
        } else {
            $columns = implode(', ', array_keys($data));
            $placeholders = implode(', ', array_fill(0, count($data), '?'));
            $values = array_values($data);

            $sql = "INSERT INTO $table ($columns) VALUES ($placeholders)";
            $stmt = self::db()->prepare($sql);
            $stmt->execute($values);

            $this->attributes['id'] = self::db()->lastInsertId();
            return $this;
        }
    }


    public static function find($id) 
    {
        $table = static::$table;
        $stmt = self::db()->prepare("SELECT * FROM $table WHERE id = ?");
        $stmt->execute([$id]);
        $data = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($data) {
            return (new static())->fill($data);
        }

        return null;
    }

    public static function where($column, $value = null) 
    {
        $instance = new static();

        if (is_array($column)) {
            $instance->conditions = $column;
        } else {
            $instance->conditions = [$column => $value];
        }

        return $instance;
    }

    public static function orderBy($column, $direction = 'ASC') 
    {
        $instance = new static();
        return $instance->orderByInstance($column, $direction);
    }

    protected function orderByInstance($column, $direction = 'ASC') 
    {
        $direction = strtoupper($direction);
        if (!in_array($direction, ['ASC', 'DESC'])) {
            $direction = 'ASC';
        }

        $this->order = "ORDER BY $column $direction";
        return $this;
    }

    public function get() 
    {
        $table = static::$table;
        $columns = array_keys($this->conditions);
        $placeholders = implode(' AND ', array_map(fn($col) => "$col = ?", $columns));
        $values = array_values($this->conditions);

        $sql = "SELECT * FROM $table";
        if (!empty($this->conditions)) {
            $sql .= " WHERE $placeholders";
        }
        if (!empty($this->order)) {
            $sql .= " " . $this->order;
        }

        $stmt = self::db()->prepare($sql);
        $stmt->execute($values);

        $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return array_map(fn($row) => (new static())->fill($row), $rows);
    }

    public function first() 
    {
        $table = static::$table;
        $columns = array_keys($this->conditions);
        $placeholders = implode(' AND ', array_map(fn($col) => "$col = ?", $columns));
        $values = array_values($this->conditions);

        $sql = "SELECT * FROM $table";
        if (!empty($this->conditions)) {
            $sql .= " WHERE $placeholders";
        }
        if (!empty($this->order)) {
            $sql .= " " . $this->order;
        }
        $sql .= " LIMIT 1";

        $stmt = self::db()->prepare($sql);
        $stmt->execute($values);
        $data = $stmt->fetch(PDO::FETCH_ASSOC);

        return $data ? (new static())->fill($data) : null;
    }

    public static function all() 
    {
        $table = static::$table;
        $stmt = self::db()->query("SELECT * FROM $table");
        $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return array_map(fn($row) => (new static())->fill($row), $rows);
    }

    public static function create(array $data) 
    {
        $model = new static();
        $model->fill($data);
        return $model->save();
    }

    public static function update($id, array $data) 
    {
        $model = static::find($id);
        if (!$model) {
            return null;
        }

        $model->fill($data);
        return $model->save();
    }

    public static function delete($id) 
    {
        $table = static::$table;
        $sql = "DELETE FROM $table WHERE id = ?";
        $stmt = self::db()->prepare($sql);
        return $stmt->execute([$id]);
    }
}