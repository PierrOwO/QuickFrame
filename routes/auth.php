<?php
use Support\Core\Route;
use Support\Core\View;
use Support\Core\Log;
use Support\Core\Auth;
use App\Controllers\AUTH\LoginController;

/**
 * File: routes/auth.php
 *
 * This file is used to define authentication-related routes,
 * such as login, logout, registration, and password reset.
 *
 * These routes are essential for user access control and session management.
 *
 * Example usage:
 * Route::get('/login', [AuthController::class, 'showLoginForm']);
 * Route::post('/login', [AuthController::class, 'login']);
 * Route::post('/logout', [AuthController::class, 'logout']);
 *
 * In this file, you can:
 * - Set up authentication logic
 * - Handle form submissions for login and registration
 * - Secure routes with custom middleware or session checks
 */