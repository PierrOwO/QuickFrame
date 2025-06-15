<?php

namespace Support\Core;

class View
{
    protected static array $sections = [];
    protected static string $extends = '';

    public static function render(string $template, array $data = [])
    {
        self::$sections = [];
        self::$extends = '';
    
        $path = str_contains($template, '.')
            ? str_replace('.', '/', $template)
            : $template;
    
        $viewPath = dirname(__DIR__, 2) . '/resources/views/' . $path . '.frame.php';
        if (!file_exists($viewPath)) {
            throw new \Exception("View $template not found.");
        }
    
        extract($data);
    
        $rawView = file_get_contents($viewPath);
        $compiledView = self::compileTemplate($rawView);
    
        $tempViewFile = tempnam(sys_get_temp_dir(), 'view_');
        file_put_contents($tempViewFile, $compiledView);
    
        ob_start();
        include $tempViewFile;
        unlink($tempViewFile);
        $viewContent = ob_get_clean();

    
        if (self::$extends) {
            $layoutPath = dirname(__DIR__, 2) . '/resources/views/' . str_replace('.', '/', self::$extends) . '.frame.php';
            if (!file_exists($layoutPath)) {
                throw new \Exception("Layout " . self::$extends . " not found.");
            }
    
            $rawLayout = file_get_contents($layoutPath);
            $compiledLayout = self::compileTemplate(
                preg_replace_callback('/@yield\([\'"](.+?)[\'"]\)/', function ($matches) {
                    return self::$sections[$matches[1]] ?? '';
                }, $rawLayout)
            );
    
            $tempLayoutFile = tempnam(sys_get_temp_dir(), 'layout_');
            file_put_contents($tempLayoutFile, $compiledLayout);
            include $tempLayoutFile;
            unlink($tempLayoutFile);
        } else {
            echo $viewContent;
        }
    }

    public static function extends(string $layout)
    {
        self::$extends = $layout;
    }

    public static function section(string $name, string $content)
    {
        self::$sections[$name] = $content;
    }

    protected static function compileTemplate(string $content): string
    {
        $content = preg_replace_callback('/{{\s*(.+?)\s*}}/', function ($matches) {
            return '<?= htmlspecialchars(' . $matches[1] . ', ENT_QUOTES, "UTF-8") ?>';
        }, $content);
        
        $content = preg_replace_callback('/{{{\s*(.+?)\s*}}}/', function ($matches) {
            return '<?= ' . $matches[1] . ' ?>';
        }, $content);
    
        $content = preg_replace_callback('/@php(.*?)@endphp/s', function ($matches) {
            return "<?php " . trim($matches[1]) . " ?>";
        }, $content);
    


        $content = preg_replace_callback('/@if\s*\(([^()]*(?:\([^()]*\)[^()]*)*)\)/', function ($matches) {
            return '<?php if (' . $matches[1] . '): ?>';
        }, $content);
        $content = preg_replace_callback('/@elseif\s*\(([^()]*(?:\([^()]*\)[^()]*)*)\)/', function ($matches) {
            return '<?php elseif (' . $matches[1] . '): ?>';
        }, $content);
        
        $content = preg_replace('/@else/', '<?php else: ?>', $content);
        $content = preg_replace('/@endif/', '<?php endif; ?>', $content);
                
    
      
        $content = preg_replace_callback('/@foreach\s*\((.*?)\)/s', function ($matches) {
            return '<?php foreach (' . $matches[1] . '): ?>';
        }, $content);
    
        $content = preg_replace('/@endforeach\b/', '<?php endforeach; ?>', $content);
    
        $content = preg_replace_callback(
            '/^[\t ]*@section\([\'"](.+?)[\'"]\s*,\s*[\'"](.+?)[\'"]\)/m',
            function ($matches) {
                $name = $matches[1];
                $sectionContent = $matches[2];
                return "<?php \\Support\\Core\\View::section('$name', '$sectionContent'); ?>";
            },
            $content
        );
    
        $content = preg_replace_callback(
            '/^[\t ]*@section\([\'"](.+?)[\'"]\)(.*?)@endsection/sm',
            function ($matches) {
                $name = $matches[1];
                $code = $matches[2];
                return "<?php ob_start(); ?>$code<?php \\Support\\Core\\View::section('$name', ob_get_clean()); ?>";
            },
            $content
        );
    
        $content = preg_replace_callback(
            '/^[\t ]*@extends\([\'"](.+?)[\'"]\)/m',
            function ($matches) {
                return "<?php \\Support\\Core\\View::extends('{$matches[1]}'); ?>";
            }, 
            $content
        );
        
        return $content;
    }
}