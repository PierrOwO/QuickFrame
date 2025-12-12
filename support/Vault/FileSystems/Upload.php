<?php

namespace Support\Vault\FileSystems;

use Support\Vault\Sanctum\Storage;

class Upload
{
    protected array $file = [];
    protected string $path = '';
    protected string $disk = 'public';
    protected ?string $fileName = null;
    protected int $maxSize;
    protected array $allowedMime = [];
    protected array $blockedExtensions = ['php', 'js', 'exe', 'sh', 'bat', 'pl'];

    protected function __construct()
    {
        $this->maxSize = config('filesystems.file_max_size');
    }

    /* ──────────────────────────────────────────────── */
    /* PRESETS                                          */
    /* ──────────────────────────────────────────────── */

    public static function image(): self
    {
        $instance = new self();
        $instance->allowedMime = ['image/jpeg', 'image/png', 'image/webp', 'image/gif', 'image/svg+xml'];
        return $instance;
    }

    public static function pdf(): self
    {
        $instance = new self();
        $instance->allowedMime = ['application/pdf'];
        $instance->maxSize = 10 * 1024 * 1024;
        return $instance;
    }

    public static function video(): self
    {
        $instance = new self();
        $instance->allowedMime = ['video/mp4', 'video/webm', 'video/ogg'];
        $instance->maxSize = 50 * 1024 * 1024;
        return $instance;
    }

    public static function audio(): self
    {
        $instance = new self();
        $instance->allowedMime = ['audio/mpeg', 'audio/ogg', 'audio/wav'];
        $instance->maxSize = 50 * 1024 * 1024;
        return $instance;
    }

    public static function document(): self
    {
        $instance = new self();
        $instance->allowedMime = [
            'application/msword',
            'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
            'application/vnd.ms-excel',
            'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
            'application/vnd.ms-powerpoint',
            'application/vnd.openxmlformats-officedocument.presentationml.presentation',
            'text/plain',
            'application/rtf'
        ];
        $instance->maxSize = 20 * 1024 * 1024;
        return $instance;
    }

    public static function archive(): self
    {
        $instance = new self();
        $instance->allowedMime = ['application/zip', 'application/vnd.rar', 'application/x-7z-compressed', 'application/gzip'];
        $instance->maxSize = 100 * 1024 * 1024;
        return $instance;
    }

    public static function make(): self
    {
        return new self();
    }

    /* ──────────────────────────────────────────────── */
    /* FILE DATA                                        */
    /* ──────────────────────────────────────────────── */

    public function file(array $file): self
    {
        $this->file = $file;
        return $this;
    }

    public function fileName(string $fileName): self
    {
        $this->fileName = trim($fileName);
        return $this;
    }

    public function maxSize(int $megabytes): self
    {
        $this->maxSize = $megabytes * 1024 * 1024;
        return $this;
    }

    public function path(string $targetPath): self
    {
        $this->path = trim($targetPath, '/');
        return $this;
    }

    public function disk(string $targetDisk): self
    {
        $this->disk = strtolower($targetDisk);
        return $this;
    }

    /* ──────────────────────────────────────────────── */
    /* VALIDATION + SAVE                                */
    /* ──────────────────────────────────────────────── */

    protected function validate(): void
    {
        if (empty($this->file)) {
            throw new \Exception('No file uploaded.');
        }

        if ($this->hasError($this->file)) {
            throw new \Exception('Upload error: ' . $this->file['error']);
        }

        if (!$this->isFileSafe($this->file)) {
            throw new \Exception('File type is blocked.');
        }

        if (!$this->isFileSizeValid($this->file)) {
            throw new \Exception('File size exceeded.');
        }

        if (!empty($this->allowedMime)) {
            $mime = mime_content_type($this->file['tmp_name']);
            if (!in_array($mime, $this->allowedMime)) {
                throw new \Exception("Invalid MIME type: $mime");
            }
        }
    }

    public function save(): string
    {
        $this->validate();

        $ext = pathinfo($this->file['name'], PATHINFO_EXTENSION);

        $filename = $this->fileName
            ? pathinfo($this->fileName, PATHINFO_FILENAME) . '.' . $ext
            : uniqid('', true) . '_' . basename($this->file['name']);

        $fullPath = $this->path . '/' . $filename;

        if (!Storage::disk($this->disk)->put($fullPath, $this->file)) {
            throw new \Exception('Failed to save file.');
        }

        return Storage::disk($this->disk)->url($fullPath);
    }

    /* helpers */

    protected function isFileSafe(array $file): bool
    {
        $ext = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
        return !in_array($ext, $this->blockedExtensions);
    }

    protected function isFileSizeValid(array $file): bool
    {
        return $file['size'] <= $this->maxSize;
    }

    protected static function hasError(array $file): bool
    {
        return $file['error'] !== UPLOAD_ERR_OK;
    }
}