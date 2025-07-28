<?php

namespace Support\Vault\FTP;

use Support\Vault\Sanctum\Log;

require __DIR__ . '/../Foundation/helpers.php';

class GitFtp
{

    public static function push(): void
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
        echo "Starting deployment with Git-FTP...\n";
        shell_exec('git config git-ftp.url ' . escapeshellarg($url));
        shell_exec('git config git-ftp.user ' . escapeshellarg($user));
        shell_exec('git config git-ftp.password ' . escapeshellarg($password));
        Log::info('url: ' . escapeshellarg($url));
        Log::info('user: ' . escapeshellarg($user));
        Log::info('password: ' . escapeshellarg($password));

        $output = shell_exec('git ftp push 2>&1');
        echo $output;

        echo "Deployment finished!\n";
    }
    public static function init(): void
    {
        $url = config('app.ftp_url');
        $user = config('app.ftp_user');
        $password = config('app.ftp_password');
        shell_exec('git config git-ftp.url ' . escapeshellarg($url));
        shell_exec('git config git-ftp.user ' . escapeshellarg($user));
        shell_exec('git config git-ftp.password ' . escapeshellarg($password));
        shell_exec('git ftp init');
        echo "Deployment finished!\n";

    }
}