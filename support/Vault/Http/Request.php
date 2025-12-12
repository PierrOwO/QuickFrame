<?php

namespace Support\Vault\Http;

use Support\Vault\Validation\VerifyCsrfToken;

class Request
{
    protected array $get;
    protected array $post;
    protected array $server;
    protected array $files;
    protected array $json;

    public function __construct()
    {
        $this->get    = $_GET;
        $this->post   = $_POST;
        $this->server = $_SERVER;
        $this->files  = $_FILES;

        $rawInput = file_get_contents('php://input');
        $this->json = json_decode($rawInput, true) ?? [];

        VerifyCsrfToken::handle();
    }

    /* -------------------------
     * BASIC INPUT ACCESS
     * ------------------------- */

    public function input(string $key, $default = null)
    {
        return $this->post[$key]
            ?? $this->get[$key]
            ?? $this->json[$key]
            ?? $default;
    }

    public function has(string $key): bool
    {
        return isset($this->post[$key])
            || isset($this->get[$key])
            || isset($this->json[$key]);
    }

    public function all(): array
    {
        return array_merge($this->get, $this->post, $this->json);
    }

    public function only(array $keys): array
    {
        $data = $this->all();
        return array_filter($data, fn($k) => in_array($k, $keys), ARRAY_FILTER_USE_KEY);
    }

    public function except(array $keys): array
    {
        $data = $this->all();
        return array_filter($data, fn($k) => !in_array($k, $keys), ARRAY_FILTER_USE_KEY);
    }

    /* -------------------------
     * FILES
     * ------------------------- */

    public function hasFile(string $key): bool
    {
        return isset($this->files[$key]) && $this->files[$key]['error'] === UPLOAD_ERR_OK;
    }

    public function file(string $key): ?array
    {
        return $this->files[$key] ?? null;
    }

    /* -------------------------
     * HTTP META
     * ------------------------- */

    public function method(): string
    {
        return strtoupper($this->server['REQUEST_METHOD'] ?? 'GET');
    }

    public function isMethod(string $method): bool
    {
        return strtoupper($method) === $this->method();
    }

    public function header(string $key, $default = null)
    {
        $header = 'HTTP_' . strtoupper(str_replace('-', '_', $key));
        return $this->server[$header] ?? $default;
    }

    public function bearerToken(): ?string
    {
        $auth = $this->header('Authorization');
        if (!$auth) return null;

        if (preg_match('/Bearer\s(.+)/', $auth, $matches)) {
            return $matches[1];
        }

        return null;
    }

    /* -------------------------
     * JSON
     * ------------------------- */

    public function json(): array
    {
        return $this->json;
    }

    public function isJson(): bool
    {
        $contentType = $this->header('Content-Type', '');
        return stripos($contentType, 'application/json') !== false;
    }

    public function expectsJson(): bool
    {
        $accept = $this->header('Accept', '');
        return stripos($accept, 'application/json') !== false;
    }

    /* -------------------------
     * AJAX
     * ------------------------- */

    public function isAjax(): bool
    {
        return strtolower($this->header('X-Requested-With', '')) === 'xmlhttprequest';
    }
}