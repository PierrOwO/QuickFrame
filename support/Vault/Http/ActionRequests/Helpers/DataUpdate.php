<?php

namespace Support\Vault\Http\ActionRequests\Helpers;

use Support\Vault\Http\ActionRequests\Handlers\DataUpdateHandler;

class DataUpdate
{
    
    protected DataUpdateHandler $handler;
    protected string $table;
    protected string $action;
    protected array $where = [];
    protected array $data = [];

    public function __construct()
    {
        $this->handler = new DataUpdateHandler();
    }

    public static function table(string $tableName = "users"): self
    {
        $instance = new self();
        $instance->table = $tableName;
        return $instance;
    }

    public function action(string $actionType = "update"): self
    {
        $this->action = $actionType;
        return $this;
    }
    public function where(array $whereArray = [])
    {
        $this->where = $whereArray;
        return $this;
    }
    public function data(array $dataArray = [])
    {
        $this->data = $dataArray;
        return $this;
    }
    public function create()
    {
        return $this->handler->create($this->table, $this->action, $this->where, $this->data);
    }
    
}