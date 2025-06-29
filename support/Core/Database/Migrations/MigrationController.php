<?php
namespace Support\Core\Database\Migrations;

use Support\Core\Database\Schema;
use Support\Core\Log;
use Support\Core\Request;

class MigrationController
{
    public function index()
    {
        $path = base_path('database/migrations');
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

        return view('migrations', ['migrations' => $files]);
    }

    public function run(Request $request)
    {
        $file = $request->input('migration');
        $path = base_path('database/migrations/' . basename($file));

        if (!file_exists($path)) {
            $content = "Migration file not found.";
        }

        $migration = require $path;

        if (is_object($migration) && method_exists($migration, 'up')) {
            try {
                $migration->up();
                Schema::logMigration($file);
    
                $content =  'Migration ran successfully.';
            } catch (\Exception $e) {
                $content = $e->getMessage();
            }
        }
        else{
            $content =  "Invalid migration file.";
        }
        $content =  <<<HTML
        <pre style="margin: auto; width: 100%; margin: 10px; background: #f8f8fff; white-space: pre-wrap;">{$content}</pre>
        HTML;
        return response()->json(['data' => $content]);
    }
    public function drop(Request $request)
    {
        $file = $request->input('migration');
        $path = base_path('database/migrations/' . basename($file));

        if (!file_exists($path)) {
            $content = "Migration file not found.";
        }

        $migration = require $path;

        if (is_object($migration) && method_exists($migration, 'down')) {
            try {
                $migration->down();
                Schema::removeMigration($file);
    
                $content =  'Migration dropped successfully.';
            } catch (\Exception $e) {
                $content = $e->getMessage();
            }
        }
        else{
            $content =  "Invalid migration file.";
        }
        $content = <<<HTML
        <pre style="margin: auto; width: 100%; margin: 10px; background: #f8f8fff; white-space: pre-wrap;">{$content}</pre>
        HTML;
        return response()->json(['data' => $content]);
    }

    public function show(Request $request)
    {   
        $file = $request->input('migration');
        $path = base_path('database/migrations/' . basename($file));
        
        if (!file_exists($path)) {
            return "Migration file not found.";
        }

        $content = htmlentities(file_get_contents($path));

        $content = <<<HTML
        <pre style="margin: auto; width: 100%; padding: 1rem; background: #f8f8fff; white-space: pre-wrap;">{$content}</pre>
        HTML;
       return response()->json(['data' => $content]);
    }
}