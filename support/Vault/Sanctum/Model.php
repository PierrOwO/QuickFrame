<?php

namespace Support\Vault\Sanctum;

use \PDO;

class Model {
    protected static $table;
    protected static $connection;
    protected static $fillable = [];

    protected $attributes = [];
    protected $conditions = [];
    protected $order = '';
    protected $orConditions = [];
    protected $select = '*';
    
    protected bool $timestamps = true;

    public function __construct(array $attributes = [])
    {
        $this->attributes = $attributes;

        foreach ($attributes as $key => $value) {
            $this->$key = $value;
        }
    }
    public function select(...$columns)
    {
        $this->select = implode(', ', $columns);
        return $this;
    }
    public function value(string $column)
    {
        $result = $this->select($column)->first();
        return $result ? $result->$column : null;
    }
    protected function currentTimestamp(): string
    {
        return date('Y-m-d H:i:s');
    }
    
    public static function generateUuid(): string
    {
        $data = random_bytes(16);
        $data[6] = chr(ord($data[6]) & 0x0f | 0x40);
        $data[8] = chr(ord($data[8]) & 0x3f | 0x80);
        return vsprintf('%s%s-%s-%s-%s-%s%s%s', str_split(bin2hex($data), 4));
    }
    public static function db() 
    {
        if (!self::$connection) {
            $config = config('database.connections.mysql');

            $host = $config['host'];
            $dbname = $config['database'];
            $user = $config['username'];
            $pass = $config['password'];
            

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

    public function fill(array $data, bool $strict = false)
    {
        $this->attributes = $strict
            ? array_intersect_key($data, array_flip(static::$fillable))
            : $data;

        foreach ($this->attributes as $key => $value) {
            $this->$key = $value;
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

        if ($this->timestamps) {
            $now = $this->currentTimestamp();
        }

        if (isset($this->attributes['id'])) {
            $id = $this->attributes['id'];
            unset($data['id']);

            if ($this->timestamps) {
                $data['updated_at'] = $now;
            }

            $set = implode(', ', array_map(fn($key) => "$key = ?", array_keys($data)));
            $values = array_values($data);
            $values[] = $id;

            $sql = "UPDATE $table SET $set WHERE id = ?";
            $stmt = self::db()->prepare($sql);
            $stmt->execute($values);

            return self::find($id);
        } else {
            if ($this->timestamps) {
                $data['created_at'] = $now;
                $data['updated_at'] = $now;
            }

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
            return (new static())->fill($data, false);
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

        $whereParts = [];
        $values = [];

        foreach ($this->conditions as $col => $val) {
            $whereParts[] = "$col = ?";
            $values[] = $val;
        }

        foreach ($this->orConditions as [$col, $val]) {
            $whereParts[] = "$col = ?";
            $values[] = $val;
        }

        $whereClause = '';
        $andCount = count($this->conditions);
        $orCount = count($this->orConditions);

        if ($andCount && $orCount) {
            $andPart = implode(' AND ', array_slice($whereParts, 0, $andCount));
            $orPart = implode(' OR ', array_slice($whereParts, $andCount));
            $whereClause = "WHERE ($andPart) OR ($orPart)";
        } elseif ($andCount) {
            $whereClause = "WHERE " . implode(' AND ', $whereParts);
        } elseif ($orCount) {
            $whereClause = "WHERE " . implode(' OR ', $whereParts);
        }

        $sql = "SELECT {$this->select} FROM $table";
        if (!empty($whereClause)) {
            $sql .= " $whereClause";
        }
        if (!empty($this->order)) {
            $sql .= " " . $this->order;
        }

        $stmt = self::db()->prepare($sql);
        $stmt->execute($values);

        $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return array_map(fn($row) => (new static())->fill($row, false), $rows);
    }

    public function first() 
    {
        $table = static::$table;

        $whereParts = [];
        $values = [];

        foreach ($this->conditions as $col => $val) {
            $whereParts[] = "$col = ?";
            $values[] = $val;
        }

        foreach ($this->orConditions as [$col, $val]) {
            $whereParts[] = "$col = ?";
            $values[] = $val;
        }

        $whereClause = '';
        $andCount = count($this->conditions);
        $orCount = count($this->orConditions);

        if ($andCount && $orCount) {
            $andPart = implode(' AND ', array_slice($whereParts, 0, $andCount));
            $orPart = implode(' OR ', array_slice($whereParts, $andCount));
            $whereClause = "WHERE ($andPart) OR ($orPart)";
        } elseif ($andCount) {
            $whereClause = "WHERE " . implode(' AND ', $whereParts);
        } elseif ($orCount) {
            $whereClause = "WHERE " . implode(' OR ', $whereParts);
        }

        $sql = "SELECT {$this->select} FROM $table";
        if (!empty($whereClause)) {
            $sql .= " $whereClause";
        }
        if (!empty($this->order)) {
            $sql .= " " . $this->order;
        }
        $sql .= " LIMIT 1";

        $stmt = self::db()->prepare($sql);
        $stmt->execute($values);
        $data = $stmt->fetch(PDO::FETCH_ASSOC);

        return $data ? (new static())->fill($data, false) : null;
    }

    public static function all() 
    {
        $table = static::$table;
        $stmt = self::db()->query("SELECT * FROM $table");
        $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return array_map(fn($row) => (new static())->fill($row, false), $rows);
    }

    public static function create(array $data) 
    {
        $model = new static();

        if (property_exists($model, 'fillable') && in_array('unique_id', static::$fillable)) {
            if (!isset($data['unique_id']) || empty($data['unique_id'])) {
                $data['unique_id'] = static::generateUuid();
            }
        }

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
    public static function exists($column, $value = null): bool
    {
        return self::where($column, $value)->first() !== null;
    }
    public function orWhere($column, $value = null)
    {
        if (is_array($column)) {
            foreach ($column as $key => $val) {
                $this->orConditions[] = [$key, $val];
            }
        } else {
            $this->orConditions[] = [$column, $value];
        }

        return $this;
    }
}