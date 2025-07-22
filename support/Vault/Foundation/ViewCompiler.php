<?php 
namespace Support\Vault\Foundation;

use Support\Vault\Sanctum\View;

class ViewCompiler
{
    protected string $viewPath;
    protected string $cachePath;

    public function __construct()
    {
        $this->viewPath = base_path('resources/views/');
        $this->cachePath = base_path('storage/cache/views/');
    }

    public function compile(string $view): string
    {
        $viewFile = $this->viewPath . str_replace('.', '/', $view) . '.frame.php';
        $compiledFile = $this->cachePath . str_replace('.', '/', $view) . '.cache.php';

        if (!file_exists($compiledFile) || filemtime($compiledFile) < filemtime($viewFile)) {
            $content = file_get_contents($viewFile);
            $compiled = View::compileTemplate($content);

            $compiledDir = dirname($compiledFile);
            if (!is_dir($compiledDir)) {
                mkdir($compiledDir, 0755, true);
            }

            file_put_contents($compiledFile, $compiled);
        }

        return $compiledFile;
    }
}