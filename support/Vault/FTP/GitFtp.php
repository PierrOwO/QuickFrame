<?php

namespace Support\Vault\FTP;

use Support\Vault\Sanctum\Log;

require __DIR__ . '/../Foundation/helpers.php';

class GitFtp
{
    public static function isGitFtpAvailable(): bool
    {
        $isWindows = strtoupper(substr(PHP_OS, 0, 3)) === 'WIN';
    
        if ($isWindows) {
            $outputWsl = null;
            $returnVarWsl = null;
            exec('wsl git ftp --version 2>&1', $outputWsl, $returnVarWsl);
            if ($returnVarWsl === 0) {
                return true;
            }
    
            $outputWin = null;
            $returnVarWin = null;
            exec('git ftp --version 2>&1', $outputWin, $returnVarWin);
            return $returnVarWin === 0;
        } else {
            $output = null;
            $returnVar = null;
            exec('git ftp --version 2>&1', $output, $returnVar);
            return $returnVar === 0;
        }
    }
    public static function push(): void
    {
        if (!self::isGitFtpAvailable()) {
            echo "Error: git-ftp is not installed or not available in your PATH.\n";
            echo "On Windows, please install WSL and git-ftp inside WSL or install git-ftp natively.\n";
            echo "See README for instructions.\n";
            return;
        }
    
        echo "Starting deployment with Git-FTP...\n";
        echo "Processing...\n";
        $output = shell_exec('git ftp push 2>&1');
        echo $output;
        echo "Deployment finished!\n";
    }
    
    public static function init(): void
    {
        if (!self::isGitFtpAvailable()) {
            echo "Error: git-ftp is not installed or not available in your PATH.\n";
            echo "On Windows, please install WSL and git-ftp inside WSL or install git-ftp natively.\n";
            echo "See README for instructions.\n";
            return;
        }
    
        $url = config('app.ftp_url');
        $user = config('app.ftp_user');
        $password = config('app.ftp_password');
    
        echo "Checking config data...\n";
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
    
        echo "Processing...\n";
        shell_exec('git config git-ftp.url ' . escapeshellarg($url));
        shell_exec('git config git-ftp.user ' . escapeshellarg($user));
        shell_exec('git config git-ftp.password ' . escapeshellarg($password));
        shell_exec('git ftp init');
        echo "Deployment finished!\n";
    }
}