<?php

namespace Support\Core;

use Support\Validate\VerifyCsrfToken;

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

    public function input($key, $default = null)
    {
        return $this->post[$key] ?? $this->get[$key] ?? $default;
    }

    public function all()
    {
        return array_merge($this->get, $this->post);
    }

    public function hasFile($key)
    {
        return isset($this->files[$key]) && $this->files[$key]['error'] === UPLOAD_ERR_OK;
    }

    public function file($key)
    {
        return $this->files[$key] ?? null;
    }
}