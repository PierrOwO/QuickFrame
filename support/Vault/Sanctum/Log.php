<?php 

namespace Support\Vault\Sanctum;

//require __DIR__ . '/../Foundation/helpers.php';
class Log
{
    public static function log(string $message, string $type = 'info', array $context = []): void
    {
        $date = date('Y-m-d H:i:s');
        $logLine = "[$date][$type] $message";
        if (!empty($context)) {
            $logLine .= ' | ' . json_encode($context, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
        }

        $logLine .= PHP_EOL;
        $logDir = base_path('storage/logs/' . date('Y') . '/' . date('m') . '/');
        $logFile = $logDir . date('d') . '.log';

        if (!is_dir($logDir)) {
            mkdir($logDir, 0777, true); 
        }

        file_put_contents($logFile, $logLine, FILE_APPEND);
    }

    public static function info($message)
    {
        self::log($message, 'INFO');
    }

    public static function error($message, $trace = null)
    {
        if ($trace) {
            if (is_array($trace)) {
                $message .= "\n" . implode("\n", array_map([self::class, 'shortenPath'], $trace));
            } else {
                $lines = explode("\n", $trace);
                foreach ($lines as &$line) {
                    $line = self::shortenPath($line);
                }
                $message .= "\n" . implode("\n", $lines);
            }
        }

        self::log($message, 'ERROR');
    }
    public static function shortenPath(string $path): string
    {
       // $basePath = base_path('some/path/to/file');
        //return str_replace($basePath, '', $path);
        return $path;
    }
    public static function debug(string $message, array $context = []): void
    {
        self::log($message, 'DEBUG', $context);
    }
}