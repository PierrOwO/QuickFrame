<?php

namespace Support\Vault\FileSystems;

use Support\Vault\Sanctum\Storage;
use Exception;

class Zip
{
    protected string $zipName;
    protected string $targetPath;
    protected string $disk = 'public';

    protected array $files = [];
    protected array $folders = [];

    public static function new(string $zipName, bool $uniqueName = false): self
    {
        $instance = new self();

        if (!str_ends_with($zipName, '.zip')) {
            $zipName .= '.zip';
        }
        if($uniqueName)
        {
            $zipName = uniqid('', true) . '_' . $zipName;
        }

        $instance->zipName = $zipName;

        return $instance;
    }

    public function disk(string $targetDisk = 'public') : self {
        $this->disk = $targetDisk;
        return $this;
    }

    public function path(string $targetPath): self
    {
        $this->targetPath = trim($targetPath, '/');
        return $this;
    }

    public function files(array $files): self
    {
        $this->files = array_merge($this->files, $files);
        return $this;
    }

    public function folder(string $targetFolder): self
    {
        $this->folders[] = $targetFolder;
        return $this;
    }

    public function create(): string
    {
        if (empty($this->files) && empty($this->folders)) {
            throw new Exception("ZIP is empty — no files or folders added.");
        }

        $zipPath = $this->targetPath . '/' . $this->zipName;

        Storage::disk($this->disk)->makeDirectory($this->targetPath);

        $fullZipPath = Storage::disk($this->disk)->path($zipPath);

        $zip = new \ZipArchive();
        if ($zip->open($fullZipPath, \ZipArchive::CREATE | \ZipArchive::OVERWRITE) !== true) {
            throw new Exception("Unable to create ZIP: {$fullZipPath}");
        }

        // FILES
        foreach ($this->files as $file) {
            $disk = $file['disk'] ?? 'public';
            $path = $file['path'] ?? null;

            if (!$path || !Storage::disk($disk)->exists($path)) {
                continue;
            }

            $real = Storage::disk($disk)->path($path);
            $zip->addFile($real, basename($path));
        }

        // FOLDERS
        foreach ($this->folders as $folder) {
            $folderPath = Storage::disk($this->disk)->path($folder);

            if (!is_dir($folderPath)) {
                continue;
            }

            $real = realpath($folderPath);
            $len = strlen($real) + 1;

            $iterator = new \RecursiveIteratorIterator(
                new \RecursiveDirectoryIterator($real, \RecursiveDirectoryIterator::SKIP_DOTS),
                \RecursiveIteratorIterator::SELF_FIRST
            );

            foreach ($iterator as $file) {
                $full = $file->getRealPath();
                $local = substr($full, $len);

                if ($file->isDir()) {
                    $zip->addEmptyDir($local);
                } else {
                    $zip->addFile($full, $local);
                }
            }
        }

        $zip->close();

        return $zipPath;
    }
}