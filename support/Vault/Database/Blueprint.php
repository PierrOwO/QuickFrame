<?php

namespace Support\Vault\Database;

class Blueprint
{
    public string $table;
    protected array $columns = [];
    protected array $indexes = [];
    protected array $foreignKeys = [];
    protected array $columnRefs = [];

    public function __construct(string $table)
    {
        $this->table = $table;
    }

    public function id(): self
    {
        $this->columns[] = "`id` BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY";
        return $this;
    }

    public function increments(string $name = 'id'): self
    {
        $this->columns[] = "`$name` INT UNSIGNED AUTO_INCREMENT PRIMARY KEY";
        return $this;
    }

    public function bigIncrements(string $name = 'id'): self
    {
        $this->columns[] = "`$name` BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY";
        return $this;
    }

    public function unsignedBigInteger(string $name): ColumnDefinition
    {
        return new ColumnDefinition($this, $name, "BIGINT UNSIGNED");
    }

    public function integer(string $name, bool $unsigned = false): ColumnDefinition
    {
        $type = $unsigned ? "INT UNSIGNED" : "INT";
        return new ColumnDefinition($this, $name, $type);
    }

    public function string(string $name, int $length = 255): ColumnDefinition
    {
        return new ColumnDefinition($this, $name, "VARCHAR($length)");
    }

    public function text(string $name): ColumnDefinition
    {
        return new ColumnDefinition($this, $name, "TEXT");
    }

    public function boolean(string $name): ColumnDefinition
    {
        return new ColumnDefinition($this, $name, "TINYINT(1)");
    }

    public function timestamp(string $name): ColumnDefinition
    {
        return new ColumnDefinition($this, $name, "TIMESTAMP");
    }

    public function timestamps(): self
    {
        $this->columns[] = "`created_at` TIMESTAMP NULL DEFAULT NULL";
        $this->columns[] = "`updated_at` TIMESTAMP NULL DEFAULT NULL";
        return $this;
    }

    public function unique(string $column): self
    {
        $this->indexes[] = "UNIQUE KEY `unique_{$column}` (`$column`)";
        return $this;
    }

    public function index(string $column): self
    {
        $this->indexes[] = "INDEX `index_{$column}` (`$column`)";
        return $this;
    }
    public function addUniqueFromColumn(string $name): void
    {
        $this->indexes[] = "UNIQUE KEY `unique_{$name}` (`$name`)";
    }

    public function addIndexFromColumn(string $name): void
    {
        $this->indexes[] = "INDEX `index_{$name}` (`$name`)";
    }

    public function foreign(string $column): ForeignKeyDefinition
    {
        return new ForeignKeyDefinition($this, $column);
    }

    public function addForeignKey(string $sql): void
    {
        $this->foreignKeys[] = $sql;
    }

    public function appendRawColumn(string $definition, string $name): void
    {
        $this->columns[] = $definition;
        $this->columnRefs[$name] = &$this->columns[array_key_last($this->columns)];
    }

    public function modifyColumn(string $name, string $addition): void
    {
        if (isset($this->columnRefs[$name])) {
            $this->columnRefs[$name] .= " $addition";
        }
    }

    public function build(): void
    {
        echo "-- Creating table: {$this->table}\n";
        echo "CREATE TABLE `{$this->table}` (\n    ";
        echo implode(",\n    ", $this->columns);

        if (!empty($this->indexes)) {
            echo ",\n    " . implode(",\n    ", $this->indexes);
        }

        if (!empty($this->foreignKeys)) {
            echo ",\n    " . implode(",\n    ", $this->foreignKeys);
        }

        echo "\n) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;\n\n";
    }

    public function toSql(): string
    {
        $sql = "CREATE TABLE `{$this->table}` (\n    " . implode(",\n    ", $this->columns);

        if (!empty($this->indexes)) {
            $sql .= ",\n    " . implode(",\n    ", $this->indexes);
        }

        if (!empty($this->foreignKeys)) {
            $sql .= ",\n    " . implode(",\n    ", $this->foreignKeys);
        }

        $sql .= "\n) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;";
        return $sql;
    }
}