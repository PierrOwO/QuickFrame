<?php

use Support\Vault\Foundation\User\Controllers\UserController;
use Support\Vault\Routing\Route;

Route::prefix('web', function () {
    if(auth()->check())
    {
        Route::prefix('/user', function () {
            Route::get('/', [UserController::class, 'index']);
            Route::put('/email', [UserController::class, 'updateEmail']);
            Route::put('/password', [UserController::class, 'updatePassword']);
            Route::put('/first-name', [UserController::class, 'updateFirstName']);
            Route::put('/last-name', [UserController::class, 'updateLastName']);
            Route::delete('/', [UserController::class, 'destroy']);
        });
    };
});