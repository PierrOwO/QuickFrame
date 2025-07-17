<?php
use Support\Vault\Routing\Route;



/**
 * File: routes/api.php
 *
 * This file is intended for defining API routes for your application.
 * These routes are typically stateless and return JSON responses,
 * making them ideal for AJAX requests, mobile apps, or frontend frameworks.
 *
 * Example usage:
 * Route::get('/api/products', [ProductController::class, 'index']);
 *
 * In this file, you can:
 * - Define RESTful API endpoints
 * - Handle data exchange in JSON format
 * - Separate web routes from programmatic API access
 *
 * API routes can be prefixed (e.g. '/api') and may have middleware like authentication or rate limiting.
 */
Route::prefix('api', function () {
});