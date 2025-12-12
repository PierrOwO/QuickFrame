<?php

use Support\Vault\Database\Seeders\SeederController;
use Support\Vault\Routing\Route;

$SEEDERS_ENABLED = filter_var(env('SEEDERS_ENABLED'), FILTER_VALIDATE_BOOLEAN);

if ($SEEDERS_ENABLED) {
    Route::prefix('/seeders', function () {
        Route::get('/', [SeederController::class, 'index']);
        Route::post('/run', [SeederController::class, 'run']);
        Route::post('/show', [SeederController::class, 'show']);
    });
}else {
    Route::any('/seeders{any}', function ($any) {
        return view('errors/403', ['message' => 'Forbidden']);
    })->where('any', '.*');
}