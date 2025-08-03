<?php

namespace Support\Vault\Database\Seeders;

use Support\Vault\Http\Request;
use Support\Vault\Sanctum\Log;

class SeederController
{
    public function index()
    {
        $path = base_path('database/seeders');
        $files = [];

        if (is_dir($path)) {
            $scanned = scandir($path);
            foreach ($scanned as $file) {
                if (pathinfo($file, PATHINFO_EXTENSION) === 'php') {
                    $files[] = [
                        'name' => $file,
                        'path' => $path . '/' . $file,
                        'created_at' => date("Y-m-d H:i:s", filemtime($path . '/' . $file)),
                    ];
                }
            }
        }

        return view('seeders', ['seeders' => $files]);
    }

    public function run(Request $request)
    {
        $file = $request->input('seeder');
        $path = base_path('database/seeders/' . basename($file));
        Log::debug('path: ' . $path);

        if (!file_exists($path)) {
            $content = "Seeder file not found.";
        } else {
            $seeder = require $path;

            if (is_object($seeder) && method_exists($seeder, 'run')) {
                try {
                    $seeder->run();
                    $content = 'Seeder ran successfully.';
                } catch (\Exception $e) {
                    $content = $e->getMessage();
                }
            } else {
                $content = "Invalid seeder file.";
            }
        }

        $content = <<<HTML
        <pre style="margin: auto; width: 100%; margin: 10px; background: #f8f8fff; white-space: pre-wrap;">{$content}</pre>
        HTML;

        return response()->json(['data' => $content]);
    }

    public function show(Request $request)
    {
        $file = $request->input('seeder');
        $path = base_path('database/seeders/' . basename($file));

        if (!file_exists($path)) {
            return "Seeder file not found.";
        }

        $content = htmlentities(file_get_contents($path));

        $content = <<<HTML
        <pre style="margin: auto; width: 100%; padding: 1rem; background: #f8f8fff; white-space: pre-wrap;">{$content}</pre>
        HTML;

        return response()->json(['data' => $content]);
    }
}