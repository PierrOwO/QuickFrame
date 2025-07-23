<?php

namespace Support\Vault\Http;

use Support\Vault\Validation\VerifyCsrfToken;

class Request
{
    public $get;
    public $post;
    public $server;
    public $files;

    public function __construct()
    {
        $this->get = $_GET;
        $this->post = $_POST;
        $this->server = $_SERVER;
        $this->files = $_FILES;

        VerifyCsrfToken::handle();
    }

    /**
     * Get input from POST or GET.
     *
     * @param string $key
     * @param mixed $default
     * @return mixed
     */
    public function input($key, $default = null)
    {
        return $this->post[$key] ?? $this->get[$key] ?? $default;
    }

    /**
     * Get all input data (POST + GET).
     *
     * @return array
     */
    public function all()
    {
        return array_merge($this->get, $this->post);
    }

    /**
     * Check if a file was uploaded without errors.
     *
     * @param string $key
     * @return bool
     */
    public function hasFile($key)
    {
        return isset($this->files[$key]) && $this->files[$key]['error'] === UPLOAD_ERR_OK;
    }

    /**
     * Get uploaded file data.
     *
     * @param string $key
     * @return array|null
     */
    public function file($key)
    {
        return $this->files[$key] ?? null;
    }

    /**
     * Check if request expects a JSON response (e.g. via Axios, fetch).
     *
     * @return bool
     */
    public function expectsJson(): bool
    {
        $accept = $this->server['HTTP_ACCEPT'] ?? '';
        return stripos($accept, 'application/json') !== false;
    }

    /**
     * Check if the request is an AJAX call.
     *
     * @return bool
     */
    public function isAjax(): bool
    {
        return (
            isset($this->server['HTTP_X_REQUESTED_WITH']) &&
            strtolower($this->server['HTTP_X_REQUESTED_WITH']) === 'xmlhttprequest'
        );
    }
}