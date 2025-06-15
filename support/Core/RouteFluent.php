<?php

namespace Support\Core;

class RouteFluent
{
    public string $method;
    public string $path;
    public $callback;
    public array $wheres = [];
    public array $middleware = [];

    public function middleware(array $middleware): self
    {
        $this->middleware = $middleware;
        return $this;
    }   
    public function __construct(string $method, string $path, $callback)
    {
        $this->method = $method;
        $this->path = $path;
        $this->callback = $callback;
    }

    public function where(array $conditions): static
    {
        $this->wheres = $conditions;
        return $this;
    }
}