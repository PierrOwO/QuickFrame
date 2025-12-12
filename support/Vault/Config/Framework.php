<?php

namespace Support\Vault\Config;

class Framework
{
    public  function index()
    {
        $jsonPath = __DIR__ . '/quickframe.json';
        if (!file_exists($jsonPath)) {
            return response()->json([
                'success' => false
            ], 500);
        }

        $config = json_decode(file_get_contents($jsonPath), true);
        return response()->json([
            'success' => true,
            'frameworkName' => $config['name'] ?? 'unknown',
            'frameworkAuthor' => $config['author'] ?? 'unknown',
            'frameworkVersion' => $config['version'] ?? 'unknown',
        ]);
    }
    public static function version(): string
    {
        $jsonPath = __DIR__ . '/quickframe.json';
        if (!file_exists($jsonPath)) {
            return 'unknown';
        }

        $config = json_decode(file_get_contents($jsonPath), true);
        return $config['version'] ?? 'unknown';
    }
    public static function author(): string
    {
        $jsonPath = __DIR__ . '/quickframe.json';
        if (!file_exists($jsonPath)) {
            return 'unknown';
        }

        $config = json_decode(file_get_contents($jsonPath), true);
        return $config['author'] ?? 'unknown';
    }

    public static function name(): string
    {
        $jsonPath = __DIR__ . '/quickframe.json';
        if (!file_exists($jsonPath)) {
            return 'unknown';
        }

        $config = json_decode(file_get_contents($jsonPath), true);
        return $config['name'] ?? 'unknown';
    }
}