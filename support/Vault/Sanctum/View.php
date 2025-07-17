<?php

namespace Support\Vault\Sanctum;

class View
{
    protected static array $sections = [];
    protected static string $extends = '';

    public static function render(string $template, array $data = [])
    {
        self::$sections = [];
        self::$extends = '';

        $viewPath = self::getViewPath($template);

        if (!file_exists($viewPath)) {
            throw new \Exception("View $template not found.");
        }

        extract($data);

        if (str_ends_with($viewPath, '.frame.php')) {
            $rawView = file_get_contents($viewPath);
            $compiledView = self::compileTemplate($rawView);

            $tempViewFile = tempnam(sys_get_temp_dir(), 'view_');
            file_put_contents($tempViewFile, $compiledView);

            ob_start();
            include $tempViewFile;
            unlink($tempViewFile);
            $viewContent = ob_get_clean();

            if (self::$extends) {
                $layoutPath = self::getViewPath(self::$extends);

                if (!file_exists($layoutPath)) {
                    throw new \Exception("Layout " . self::$extends . " not found.");
                }

                $rawLayout = file_get_contents($layoutPath);
                $replacedLayout = preg_replace_callback('/@yield\([\'"](.+?)[\'"]\)/', function ($matches) {
                    return self::$sections[$matches[1]] ?? '';
                }, $rawLayout);

                $compiledLayout = self::compileTemplate($replacedLayout);

                $tempLayoutFile = tempnam(sys_get_temp_dir(), 'layout_');
                file_put_contents($tempLayoutFile, $compiledLayout);
                include $tempLayoutFile;
                unlink($tempLayoutFile);
            } else {
                echo $viewContent;
            }
        }

        elseif (str_ends_with($viewPath, '.php')) {
            include $viewPath;
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
                return "<?php \\Support\\Vault\\Sanctum\\View::section('$name', '$sectionContent'); ?>";
            },
            $content
        );
        $content = preg_replace_callback(
            '/@vite\(\s*(.+?)\s*\)/',
            function ($matches) {
                return "<?php echo vite({$matches[1]}); ?>";
            },
            $content
        );

        $content = preg_replace_callback(
            '/^[\t ]*@section\([\'"](.+?)[\'"]\)(.*?)@endsection/sm',
            function ($matches) {
                $name = $matches[1];
                $code = $matches[2];
                return "<?php ob_start(); ?>$code<?php \\Support\\Vault\\Sanctum\\View::section('$name', ob_get_clean()); ?>";
            },
            $content
        );

        $content = preg_replace_callback(
            '/^[\t ]*@extends\([\'"](.+?)[\'"]\)/m',
            function ($matches) {
                return "<?php \\Support\\Vault\\Sanctum\\View::extends('{$matches[1]}'); ?>";
            },
            $content
        );

        $content = preg_replace_callback(
            '/@include\(\s*[\'"](.+?)[\'"]\s*\)/',
            function ($matches) {
                $view = $matches[1];
                return "<?php echo \\Support\\Vault\\Sanctum\\View::renderPartial('$view'); ?>";
            },
            $content
        );

        return $content;
    }

    public static function renderPartial(string $viewName): string
    {
        $viewPath = self::getViewPath($viewName);
        if (!file_exists($viewPath)) {
            throw new \Exception("Included view [$viewName] not found at $viewPath");
        }
        $rawView = file_get_contents($viewPath);
        $compiled = self::compileTemplate($rawView);
        ob_start();
        eval('?>' . $compiled);
        return ob_get_clean();
    }

    protected static function getViewPath(string $template): string
    {
        $mainDir = dirname(__DIR__, 3);
        $specialErrorTemplates = ['errors/404', 'errors/401', 'errors/403'];

        $path = str_contains($template, '.') ? str_replace('.', '/', $template) : $template;

        if ($template === 'migrations') {
            $dir = $mainDir . '/support/Vault/Database/Migrations/';
            $frameFile = $dir . $path . '.frame.php';
            $phpFile = $dir . $path . '.php';
        } elseif (in_array($template, $specialErrorTemplates)) {
            $dir = $mainDir . '/support/Vault/Errors/Pages/';
            $path = explode('/', $path);
            $frameFile = $dir . $path[1] . '.frame.php';
            $phpFile = $dir . $path[1] . '.php';
        } else {
            $dir = $mainDir . '/resources/views/';
            $frameFile = $dir . $path . '.frame.php';
            $phpFile = $dir . $path . '.php';
        }

        if (file_exists($frameFile)) {
            return $frameFile;
        } elseif (file_exists($phpFile)) {
            return $phpFile;
        } else {
            throw new \Exception("View file for template '$template' not found neither as .frame.php or .php");
        }
    }
}