<?php

namespace Support\Vault\Sanctum;

use \PDO;

class Model {
    protected static $table;
    protected static $connection;
    protected static $fillable = [];
    protected bool $timestamps = true;

    protected $attributes = [];

    public function __construct(array $attributes = [])
    {
        $this->fill($attributes);
    }
    public static function getTable(): string 
    {
        return static::$table;
    }
    public function __get($key) 
    {
        return $this->attributes[$key] ?? null;
    }

    public function __set($key, $value) 
    {
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
            $dsn = "mysql:host={$config['host']};dbname={$config['database']};charset=utf8mb4";
            self::$connection = new PDO($dsn, $config['username'], $config['password']);
            self::$connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        }
        return self::$connection;
    }

    public static function __callStatic($name, $arguments)
    {
        $builder = new QueryBuilder(static::class);
        if (method_exists($builder, $name)) {
            return $builder->$name(...$arguments);
        }
        throw new \Exception("Method $name does not exist on QueryBuilder.");
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
            if ($this->timestamps) $data['updated_at'] = $now;

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
        if (in_array('unique_id', static::$fillable) && empty($data['unique_id'])) {
            $data['unique_id'] = static::generateUuid();
        }
        $model = new static();
        $model->fill($data);
        return $model->save();
    }

    public static function update($id, array $data) 
    {
        $model = static::find($id);
        if (!$model) return null;
        $model->fill($data);
        return $model->save();
    }

    public function delete()
    {
        $id = $this->attributes['id'] ?? null;
        if (!$id) throw new \Exception("Cannot delete a model without an ID.");
        $table = static::$table;
        $stmt = self::db()->prepare("DELETE FROM $table WHERE id = ?");
        return $stmt->execute([$id]);
    }

    public static function exists($column, $value = null): bool
    {
        return self::__callStatic('where', [$column, $value])->first() !== null;
    }
}