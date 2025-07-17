<?php 

namespace Support\Vault\Sanctum;

class Log
{
    public static function log($message, $type = 'info')
    {
        $date = date('Y-m-d H:i:s');
        $logLine = "[$date][$type] $message" . PHP_EOL;

        $logDir = __DIR__ . '/../../../storage/logs/' . date('Y') . '/' . date('m') . '/';
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
        $basePath = '/some/path/to/file';
        //return str_replace($basePath, '', $path);
        return $path;
    }
}