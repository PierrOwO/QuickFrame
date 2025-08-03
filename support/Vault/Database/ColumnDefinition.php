<?php

namespace Support\Vault\Database;

class ColumnDefinition
{
    protected Blueprint $blueprint;
    protected string $name;

    public function __construct(Blueprint $blueprint, string $name, string $definition)
    {
        $this->blueprint = $blueprint;
        $this->name = $name;
        $this->blueprint->appendRawColumn("`$name` $definition", $name);
    }

    public function nullable(): self
    {
        $this->blueprint->modifyColumn($this->name, "NULL");
        return $this;
    }

    public function default($value): self
    {
        $default = is_string($value) ? "'$value'" : $value;
        $this->blueprint->modifyColumn($this->name, "DEFAULT $default");
        return $this;
    }

    public function unique(): self
    {
        $this->blueprint->addUniqueFromColumn($this->name);
        return $this;
    }

    public function index(): self
    {
        $this->blueprint->addIndexFromColumn($this->name);
        return $this;
    }
}