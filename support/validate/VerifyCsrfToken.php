<?php

namespace Support\Validate;

class VerifyCsrfToken
{
    public static function handle(): void
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $sessionToken = $_SESSION['_csrf_token'] ?? null;
            $requestToken = $_POST['_token'] ?? $_SERVER['HTTP_X_CSRF_TOKEN'] ?? null;

            if (!$sessionToken || !$requestToken || !hash_equals($sessionToken, $requestToken)) {
                http_response_code(419); 
                die('CSRF token mismatch.');
            }
        }
    }
}