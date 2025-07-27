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
        Log::info('Auth session user_id: ' . Session::get('user_id'));
        Log::info('Auth user: ', ['user' => Auth::user()]);
        Log::info('Auth check: ' . (Auth::check() ? 'yes' : 'no'));
        if (!Auth::check()) {
            return redirect('/auth/login');
        }
        return $next($request);
    }
}