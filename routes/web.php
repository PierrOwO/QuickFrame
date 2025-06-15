<?php
use Support\Core\Route;
use Support\Core\View;
use Support\Core\Log;

/**
 * File: routes/web.php
 *
 * This file is used to define the application routes handled by your custom Route class.
 * Each route maps a specific URL path to the logic that should be executed when that path is visited,
 * such as rendering a view, calling a controller method, or processing form data.
 *
 * Example usage:
 * Route::get('/home', function () {
 *     return View::render('home');
 * });
 *
 * Common methods (depending on your implementation):
 * - Route::get($path, $action)     – registers a GET route
 * - Route::post($path, $action)    – registers a POST route
 *
 * In this file, you can:
 * - Define simple routes using closures
 * - Map URLs to controller methods
 * - Use dynamic URL segments (e.g. '/orders/{id}')
 *
 * This is the central place for managing how URLs map to your application's functionality.
 */

Route::get('/', function () {
    View::render('home');
});
