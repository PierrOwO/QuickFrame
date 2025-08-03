<?php 

namespace Support\Vault\Creation;

require __DIR__ . '/../Foundation/helpers.php';

class CreationHandler 
{

    public static function createController($name) 
    {
        if (!$name) {
            echo "Type name of the controller.\n";
            exit(1);
        }
        if (!str_ends_with($name, 'Controller')) {
            $className = $name . 'Controller';
        } else {
            $className = $name;
        }
        $stub = file_get_contents(__DIR__ . '/stubs/controller.stub');
        $stub = str_replace('ClassName', $className, $stub);

        $directory = base_path("app/Controllers");
        if (!is_dir($directory)) {
            mkdir($directory, 0777, true); 
        }
        
        $outputPath = base_path("app/Controllers/{$className}.php");
        if (file_exists($outputPath)) {
            echo "Controller already exists.\n";
            exit(1);
        }
    
        file_put_contents($outputPath, $stub);
        echo "Created controller: {$className}\n";
    }
    public static function createApiController($name) 
    {
        if (!$name) {
            echo "Type name of the controller.\n";
            exit(1);
        }
        if (!str_ends_with($name, 'Controller')) {
            $className = $name . 'Controller';
        } else {
            $className = $name;
        }
        $stub = file_get_contents(__DIR__ . '/stubs/api.stub');
        $stub = str_replace('ClassName', $className, $stub);

        $directory = base_path("app/Controllers/Api");
        if (!is_dir($directory)) {
            mkdir($directory, 0777, true); 
        }

        $outputPath = base_path("app/Controllers/Api/{$className}.php");
        if (file_exists($outputPath)) {
            echo "Controller already exists.\n";
            exit(1);
        }
    
        file_put_contents($outputPath, $stub);
        echo "Created Api controller: {$className}\n";
    }
    public static function createModel($name) 
    {
        if (!$name) {
            echo "Type name of the model.\n";
            exit(1);
        }
        $table_name = strtolower($name);
        $stub = file_get_contents(__DIR__ . '/stubs/model.stub');
        $stub = str_replace('ClassName', $name, $stub);
        $stub = str_replace('table_name', $table_name, $stub);
    
        $outputPath = base_path("app/Models/{$name}.php");
        if (file_exists($outputPath)) {
            echo "Model already exists.\n";
            exit(1);
        }
    
        file_put_contents($outputPath, $stub);
        echo "Created model: {$name}\n";
    }
    public static function createMiddleware($name) 
    {
        if (!$name) {
            echo "Type name of the middleware.\n";
            exit(1);
        }
        
        $stub = file_get_contents(__DIR__ . '/stubs/middleware.stub');
        $stub = str_replace('ClassName', $name, $stub);
    
        $outputPath = base_path("app/Middleware/{$name}.php");
        if (file_exists($outputPath)) {
            echo "Middleware already exists.\n";
            exit(1);
        }
    
        file_put_contents($outputPath, $stub);
        echo "Created middleware: {$name}\n";
    }
    public static function createHelper($name)
    {
        if (!$name) {
            echo "Type name of the helper.\n";
            exit(1);
        }
        
        $stub = file_get_contents(__DIR__ . '/stubs/helper.stub');
        $stub = str_replace('ClassName', $name, $stub);
    
        $outputPath = base_path("app/Helpers/{$name}.php");
        if (file_exists($outputPath)) {
            echo "Helper already exists.\n";
            exit(1);
        }
    
        file_put_contents($outputPath, $stub);
        echo "Created helper: {$name}\n";
    }
    public static function createView($name)
    {
        if (!$name) {
            echo "Type name of the view.\n";
            exit(1);
        }

        $stub = file_get_contents(__DIR__ . '/stubs/view.stub');
        $stub = str_replace('ViewName', $name, $stub);

        $relativePath ="resources/views/{$name}.frame.php";
        $outputPath = base_path($relativePath);

        $dir = dirname($outputPath);
        if (!is_dir($dir)) {
            mkdir($dir, 0777, true);
        }

        if (file_exists($outputPath)) {
            echo "View already exists: $relativePath\n";
            exit(1);
        }

        file_put_contents($outputPath, $stub);
        echo "Created view: $relativePath\n";
    }
    public static function createMigration($name) 
    {
        if (!$name) {
            echo "Type name of the migration (e.g. create_users_table).\n";
            exit(1);
        }

        $tableName = strtolower(preg_replace('/^create_|_table$/', '', $name));
        $timestamp = date('Y_m_d_His');
        $fileName = $timestamp . '_' . $name . '.php';

        $stub = file_get_contents(__DIR__ . '/stubs/migration.stub');
        $stub = str_replace('{{table}}', $tableName, $stub);

        $outputPath = base_path("database/migrations/{$fileName}");
        if (!is_dir(dirname($outputPath))) {
            mkdir(dirname($outputPath), 0755, true);
        }

        file_put_contents($outputPath, $stub);
        echo "Created migration: {$fileName}\n";
    }
    public static function createTest($name) 
    {
        if (!$name) {
            echo "Type name of the test (e.g. ExampleTest).\n";
            exit(1);
        }

        $stub = file_get_contents(__DIR__ . '/stubs/test.stub');
        $stub = str_replace('ClassName', $name, $stub);
    
        $outputPath = base_path("support/Tests/{$name}.php");
        if (file_exists($outputPath)) {
            echo "Test already exists.\n";
            exit(1);
        }
    
        file_put_contents($outputPath, $stub);
        echo "Created Test: {$name}\n";
    }
}