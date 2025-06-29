<?php

namespace Support\Core\Database;

class Blueprint
{
    protected string $table;
    protected array $columns = [];
    protected array $indexes = [];
    protected array $foreignKeys = [];

    protected ?string $lastColumn = null;

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

    public function unsignedBigInteger(string $name): self
    {
        $this->appendColumn("`$name` BIGINT UNSIGNED");
        return $this;
    }

    public function integer(string $name, bool $unsigned = false): self
    {
        $type = $unsigned ? "INT UNSIGNED" : "INT";
        $this->appendColumn("`$name` $type");
        return $this;
    }

    public function string(string $name, int $length = 255): self
    {
        $this->appendColumn("`$name` VARCHAR($length)");
        return $this;
    }

    public function text(string $name): self
    {
        $this->appendColumn("`$name` TEXT");
        return $this;
    }

    public function boolean(string $name): self
    {
        $this->appendColumn("`$name` TINYINT(1)");
        return $this;
    }

    public function timestamp(string $name): self
    {
        $this->appendColumn("`$name` TIMESTAMP");
        return $this;
    }

    public function timestamps(): self
    {
        $this->columns[] = "`created_at` TIMESTAMP NULL DEFAULT NULL";
        $this->columns[] = "`updated_at` TIMESTAMP NULL DEFAULT NULL";
        return $this;
    }

    public function nullable(): self
    {
        $this->modifyLastColumn('NULL');
        return $this;
    }

    public function default($value): self
    {
        $default = is_string($value) ? "'$value'" : $value;
        $this->modifyLastColumn("DEFAULT $default");
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

    public function foreign(string $column, string $referencedTable, string $referencedColumn = 'id', string $onDelete = 'CASCADE'): self
    {
        $this->foreignKeys[] = "FOREIGN KEY (`$column`) REFERENCES `$referencedTable`(`$referencedColumn`) ON DELETE $onDelete";
        return $this;
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

    protected function appendColumn(string $definition): void
    {
        $this->columns[] = $definition;
        $this->lastColumn = &$this->columns[array_key_last($this->columns)];
    }

    protected function modifyLastColumn(string $addition): void
    {
        if ($this->lastColumn !== null) {
            $this->lastColumn .= " $addition";
        }
    }
}