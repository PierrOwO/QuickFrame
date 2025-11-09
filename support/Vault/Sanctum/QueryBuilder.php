<?php 

namespace Support\Vault\Sanctum;

use \PDO;

class QueryBuilder {
    protected string $modelClass;
    protected string $table;
    protected array $conditions = [];
    protected string $order = '';
    protected string $select = '*';
    protected ?int $limit = null;

    public function __construct(string $modelClass) {
        $this->modelClass = $modelClass;
        $this->table = $modelClass::getTable(); 
    }

    public function where(string $column, $operatorOrValue, $value = null): self {
        if ($value === null) {
            $value = $operatorOrValue;
            $operatorOrValue = '=';
        }
        $this->conditions[] = [$column, $operatorOrValue, $value, 'AND'];
        return $this;
    }

    public function orWhere(string $column, $operatorOrValue, $value = null): self {
        if ($value === null) {
            $value = $operatorOrValue;
            $operatorOrValue = '=';
        }
        $this->conditions[] = [$column, $operatorOrValue, $value, 'OR'];
        return $this;
    }
    
    public function whereLike(string $column, string $pattern): self {
        $this->conditions[] = [$column, 'LIKE', $pattern, 'AND'];
        return $this;
    }

    public function orWhereLike(string $column, string $pattern): self {
        $this->conditions[] = [$column, 'LIKE', $pattern, 'OR'];
        return $this;
    }

    public function whereIn(string $column, array $values): self {
        $placeholders = implode(',', array_fill(0, count($values), '?'));
        $this->conditions[] = [$column, "IN ($placeholders)", $values, 'AND'];
        return $this;
    }

    public function whereNotIn(string $column, array $values): self {
        $placeholders = implode(',', array_fill(0, count($values), '?'));
        $this->conditions[] = [$column, "NOT IN ($placeholders)", $values, 'AND'];
        return $this;
    }
    
    public function whereNull(string $column): self {
        $this->conditions[] = [$column, 'IS NULL', null, 'AND'];
        return $this;
    }

    public function whereNotNull(string $column): self {
        $this->conditions[] = [$column, 'IS NOT NULL', null, 'AND'];
        return $this;
    }
    
    public function orderBy(string $column, string $direction = 'ASC'): self {
        $direction = strtoupper($direction) === 'DESC' ? 'DESC' : 'ASC';
        $this->order = " ORDER BY $column $direction";
        return $this;
    }

    public function limit(int $limit): self {
        $this->limit = $limit;
        return $this;
    }

    public function select(string $columns): self {
        $this->select = $columns;
        return $this;
    }
    
    protected function buildWhereClause(array &$values): string {
        if (empty($this->conditions)) {
            return '';
        }

        $parts = [];
        foreach ($this->conditions as $index => [$col, $op, $val, $boolean]) {
            $prefix = $index === 0 ? '' : " $boolean ";

            if (is_array($val)) {
                $parts[] = $prefix . "$col $op";
                foreach ($val as $v) {
                    $values[] = $v;
                }
            } elseif ($val === null && ($op === 'IS NULL' || $op === 'IS NOT NULL')) {
                $parts[] = $prefix . "$col $op";
            } else {
                $parts[] = $prefix . "$col $op ?";
                $values[] = $val;
            }
        }
        return " WHERE " . implode(' ', $parts);
    }

    public function get(): array {
        $sql = "SELECT {$this->select} FROM {$this->table}";
        $values = [];

        $sql .= $this->buildWhereClause($values);

        if ($this->order) {
            $sql .= $this->order;
        }

        if ($this->limit !== null) {
            $sql .= " LIMIT {$this->limit}";
        }

        $stmt = Model::db()->prepare($sql);
        $stmt->execute($values);

        $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $modelClass = $this->modelClass;

        return array_map(fn($row) => (new $modelClass())->fill($row, false), $rows);
    }

    public function first(): ?object {
        $this->limit(1);
        $results = $this->get();
        return $results[0] ?? null;
    }

    public function count(): int {
        $sql = "SELECT COUNT(*) as cnt FROM {$this->table}";
        $values = [];

        $sql .= $this->buildWhereClause($values);

        $stmt = Model::db()->prepare($sql);
        $stmt->execute($values);

        return (int)$stmt->fetch(PDO::FETCH_ASSOC)['cnt'];
    }
    public function exists(): bool {
        $sql = "SELECT 1 FROM {$this->table}";
        $values = [];
    
        $sql .= $this->buildWhereClause($values);
        $sql .= " LIMIT 1";
    
        $stmt = Model::db()->prepare($sql);
        $stmt->execute($values);
    
        return (bool) $stmt->fetchColumn();
    }
}