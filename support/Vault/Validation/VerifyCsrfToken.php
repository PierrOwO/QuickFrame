<?php

namespace Support\Vault\Validation;

use Support\Vault\Foundation\Session;
use Support\Vault\Sanctum\Log;

class VerifyCsrfToken
{
    public static function handle(): void
    {
        
        $methodsToCheck = ['POST', 'PUT', 'PATCH', 'DELETE'];

        if (in_array($_SERVER['REQUEST_METHOD'], $methodsToCheck, true)) {
            $sessionToken = Session::csrf() ?? null;
            $requestToken = $_POST['_token'] ?? $_SERVER['HTTP_X_CSRF_TOKEN'] ?? null;

            if (!$sessionToken || !$requestToken || !hash_equals($sessionToken, $requestToken)) {
                http_response_code(419);
                die('CSRF token mismatch.');
            }
        }
    }
}