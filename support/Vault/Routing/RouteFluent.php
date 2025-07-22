<?php

namespace Support\Vault\Routing;

class RouteFluent
{
    public string $method;
    public string $path;
    public $callback;
    public array $wheres = [];
    public array $middleware = [];

    public function __construct(string $method, string $path, $callback)
    {
        $this->method = $method;
        $this->path = $path;
        $this->callback = $callback;
    }

    public function middleware(array $middleware): self
    {
        $this->middleware = $middleware;
        return $this;
    }

    public function where(string|array $paramOrArray, ?string $pattern = null): static
    {
        if (is_array($paramOrArray)) {
            $this->wheres = array_merge($this->wheres, $paramOrArray);
        } elseif (is_string($paramOrArray) && $pattern !== null) {
            $this->wheres[$paramOrArray] = $pattern;
        }
        return $this;
    }

    public function toArray(): array
    {
        if ($this->callback instanceof \Closure) {
            throw new \Exception('Cannot serialize Closure or unknown callback type');
        }

        return [
            'method' => $this->method,
            'path' => $this->path,
            'callback' => $this->callback,
            'wheres' => $this->wheres,
            'middleware' => $this->middleware,
        ];
    }

    public static function fromArray(array $data): self
    {
        $route = new self($data['method'], $data['path'], $data['callback']);
        $route->wheres = $data['wheres'] ?? [];
        $route->middleware = $data['middleware'] ?? [];
        return $route;
    }
}