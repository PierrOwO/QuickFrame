<?php

namespace Support\Vault\FTP;

use Support\Vault\Sanctum\Log;

require __DIR__ . '/../Foundation/helpers.php';

class GitFtp
{

    public static function push(): void
    {
        echo "Starting deployment with Git-FTP...\n";

        $cmd = 'git ftp push > /tmp/gitftp_output.txt 2>&1 & echo $!';
        $pid = (int) shell_exec($cmd);

        self::showSpinner($pid, "Uploading");

        echo file_get_contents('/tmp/gitftp_output.txt');

        echo "Deployment finished!\n";
    }

protected static function showSpinner(int $processId, string $message = ''): void
{
    $spinner = ['⠋','⠙','⠸','⠴','⠦','⠇'];
    $i = 0;

    while (posix_getpgid($processId)) {
        echo "\r$message " . $spinner[$i++ % count($spinner)];
        usleep(100000); // 0.1 sekundy
    }

    echo "\r$message \033[32m✓\033[0m\n";
}
    public static function init(): void
    {
        $url = config('app.ftp_url');
        $user = config('app.ftp_user');
        $password = config('app.ftp_password');

        if (!$url || !$user || !$password) {
            $red = "\033[31m";
            $yellow = "\033[33m";
            $blue = "\033[34m";
            $reset = "\033[0m";
            $green = "\033[32m";
    
            echo "{$red}Deployment failed: Missing FTP credentials in {$yellow}config/app.php {$red}or {$yellow}.env{$red}.{$reset}\n";
            echo "{$yellow}Please update {$green}.env {$yellow}and run {$blue}php frame cache:config{$reset}\n";
            return;
        }
        
        shell_exec('git config git-ftp.url ' . escapeshellarg($url));
        shell_exec('git config git-ftp.user ' . escapeshellarg($user));
        shell_exec('git config git-ftp.password ' . escapeshellarg($password));
        shell_exec('git ftp init');
        echo "Deployment finished!\n";

    }
}