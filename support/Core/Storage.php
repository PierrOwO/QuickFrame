<?php

namespace Support\Core;

class Storage
{
    protected static $basePath = __DIR__ . '/../../storage/app';

    public static function path($path)
    {
        return rtrim(self::$basePath . '/' . ltrim($path, '/'), '/');
    }

    public static function exists($path)
    {
        return file_exists(self::path($path));
    }

    public static function makeDirectory($path, $mode = 0777, $recursive = true)
    {
        $fullPath = self::path($path);
        if (!file_exists($fullPath)) {
            return mkdir($fullPath, $mode, $recursive);
        }
        return true;
    }

    public static function put($path, $file)
    {
        if (!isset($file['tmp_name']) || !is_uploaded_file($file['tmp_name'])) {
            return false;
        }

        $fullPath = self::path($path);
        $directory = dirname($fullPath);

        if (!file_exists($directory)) {
            self::makeDirectory(dirname($path));
        }

        return move_uploaded_file($file['tmp_name'], $fullPath) ? $path : false;
    }

    public static function delete($path)
    {
        $fullPath = self::path($path);
        return file_exists($fullPath) ? unlink($fullPath) : false;
    }

    public static function url($path)
    {
        return '/storage/' . ltrim(str_replace('public/', '', $path), '/');
    }
}