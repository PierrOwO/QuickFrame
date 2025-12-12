<?php

namespace Support\Vault\Sanctum;

class Storage
{
    protected string $diskName;
    protected array $config;

    public function __construct(?string $disk = null)
    {
        $this->diskName = $disk ?: config('filesystems.default');
        $this->config = config("filesystems.disks.{$this->diskName}");

        if (!$this->config) {
            throw new \Exception("Disk '{$this->diskName}' is not defined.");
        }
    }

    public static function disk(?string $disk = null): static
    {
        return new static($disk);
    }

    public function root(): string
    {
        return rtrim($this->config['root'], '/');
    }

    public function path(string $path): string
    {
        return $this->root() . '/' . ltrim($path, '/');
    }

    public function exists(string $path): bool
    {
        return file_exists($this->path($path));
    }

    public function makeDirectory(string $path): bool
    {
        $dir = $this->path($path);
        return is_dir($dir) || mkdir($dir, 0777, true);
    }

    public function put(string $path, array $file)
    {
        if (!isset($file['tmp_name']) || !is_uploaded_file($file['tmp_name'])) {
            return false;
        }

        $fullPath = $this->path($path);
        $directory = dirname($fullPath);

        if (!is_dir($directory)) {
            $this->makeDirectory(dirname($path));
        }

        return move_uploaded_file($file['tmp_name'], $fullPath) ? $path : false;
    }

    public function get(string $path): ?string
    {
        $full = $this->path($path);
        return file_exists($full) ? file_get_contents($full) : null;
    }

    public function delete(string $path): bool
    {
        $full = $this->path($path);
        return file_exists($full) ? unlink($full) : false;
    }

    public function url(string $path): string
    {
        $root = $this->config['root'];
        $public = str_replace(base_path('storage/app/public'), '', $root);

        if (isset($this->config['url'])) {
            return rtrim($this->config['url'], '/'). '/public/' . ltrim($path, '/');
        }

        return "/storage/" . ltrim($path, '/');
    }

    public function serve(string $path)
    {
        $fullPath = $this->path($path);

        if (!file_exists($fullPath)) {
            http_response_code(404);
            exit('File not found');
        }

        $mime = mime_content_type($fullPath);
        $extension = strtolower(pathinfo($fullPath, PATHINFO_EXTENSION));

        $inlineExtensions = ['jpg', 'jpeg', 'png', 'webp', 'gif', 'pdf'];
        $disposition = in_array($extension, $inlineExtensions) ? 'inline' : 'attachment';
        if ($extension == 'pdf')
        { 
            $mime = 'application/pdf';
        }

        header("Content-Type: $mime");
        header("Content-Disposition: $disposition; filename=\"" . basename($fullPath) . "\"");
        header("Content-Length: " . filesize($fullPath));

        readfile($fullPath);
        exit;
    }

    public function download(string $path)
    {
        $fullPath = $this->path($path);

        if (!file_exists($fullPath)) {
            http_response_code(404);
            exit('File not found');
        }

        header('Content-Type: application/octet-stream');
        header('Content-Disposition: attachment; filename="' . basename($fullPath) . '"');
        header('Content-Length: ' . filesize($fullPath));

        readfile($fullPath);
        exit;
    }
}