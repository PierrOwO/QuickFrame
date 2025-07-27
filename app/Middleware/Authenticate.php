<?php
namespace App\Middleware;

use Closure;
use Support\Vault\Foundation\Auth;
use Support\Vault\Foundation\Session;
use Support\Vault\Sanctum\Log;

class Authenticate
{
    public function handle($request, Closure $next)
    {
        if (!auth()->check()) {
            return redirect('/auth/login');
        }

        return $next($request);
    }
}