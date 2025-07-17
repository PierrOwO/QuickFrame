<?php
namespace App\Middleware;

use Closure;
use Support\Vault\Foundation\Auth;

class Authenticate
{
    public function handle($request, Closure $next)
    {
        if (!Auth::check()) {
            return redirect('/login');
        }
        return $next($request);
    }
}