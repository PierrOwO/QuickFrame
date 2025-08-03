<?php

namespace Support\Vault\Database;

class ForeignKeyDefinition
{
    protected Blueprint $blueprint;
    protected string $column;
    protected ?string $reference = null;
    protected ?string $on = null;
    protected ?string $onDelete = null;

    public function __construct(Blueprint $blueprint, string $column)
    {
        $this->blueprint = $blueprint;
        $this->column = $column;
    }
    public function __destruct()
    {
        $this->apply();
    }

    public function references(string $reference): self
    {
        $this->reference = $reference;
        return $this;
    }

    public function on(string $on): self
    {
        $this->on = $on;
        return $this;
    }

    public function onDelete(string $action): self
    {
        $this->onDelete = $action;
        return $this;
    }

    public function apply(): void
    {
        if ($this->reference && $this->on) {
            $fkName = "{$this->blueprint->table}_{$this->column}_foreign";
            $sql = "CONSTRAINT `$fkName` FOREIGN KEY (`$this->column`) REFERENCES `{$this->on}`(`{$this->reference}`)";
            if ($this->onDelete) {
                $sql .= " ON DELETE {$this->onDelete}";
            }
            $this->blueprint->addForeignKey($sql);
        }
    }
}