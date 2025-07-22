<?php

namespace Support\Vault\Foundation;

class Cache
{
    protected string $path;

    public function __construct(string $basePath = null)
    {
        $this->path = $basePath ?? base_path('storage/cache/');
        if (!is_dir($this->path)) {
            mkdir($this->path, 0755, true);
        }
    }

    protected function filePath(string $key): string
    {
        return $this->path . md5($key) . '.cache.php';
    }

    public function put(string $key, mixed $value, int $minutes = 0): void
    {
        $expires = $minutes > 0 ? time() + ($minutes * 60) : 0;
        $data = ['expires' => $expires, 'value' => $value];
        $export = var_export($data, true);
        file_put_contents($this->filePath($key), "<?php return $export;");
    }

    public function get(string $key, mixed $default = null): mixed
    {
        $file = $this->filePath($key);
        if (!file_exists($file)) {
            return $default;
        }

        $data = include $file;

        if (isset($data['expires']) && $data['expires'] !== 0 && time() > $data['expires']) {
            unlink($file);
            return $default;
        }

        return $data['value'] ?? $default;
    }

    public function has(string $key): bool
    {
        return $this->get($key, '__not_found__') !== '__not_found__';
    }

    public function forget(string $key): void
    {
        $file = $this->filePath($key);
        if (file_exists($file)) {
            unlink($file);
        }
    }

    public function clear(): void
    {
        $files = glob($this->path . '*.cache.php');
        foreach ($files as $file) {
            unlink($file);
        }
    }
}