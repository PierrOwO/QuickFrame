<?php

use App\Controllers\AUTH\LoginController;
use App\Controllers\AUTH\RegisterController;
use App\Middleware\GuestMiddleware;
use Support\Vault\Foundation\Auth;
use Support\Vault\Routing\Route;


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
Route::get('/auth/login', [LoginController::class, 'index'])->middleware([GuestMiddleware::class]);
Route::get('/auth/register', [RegisterController::class, 'index'])->middleware([GuestMiddleware::class]);

Route::get('/logout', [Auth::class, 'logout']);

Route::post('/auth/login', [LoginController::class, 'login']);
Route::post('/auth/register', [RegisterController::class, 'register']);