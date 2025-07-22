<?php

use Support\Vault\Database\Migrations\MigrationController;
use Support\Vault\Routing\Route;

$MIGRATIONS_ENABLED = filter_var(env('MIGRATIONS_ENABLED'), FILTER_VALIDATE_BOOLEAN);

if (!Route::loadCache()) {
    require base_path('routes/api.php');
    require base_path('routes/auth.php');
    
    Route::saveCache();
}

require base_path('routes/web.php');

if ($MIGRATIONS_ENABLED) {
    Route::prefix('/migrations', function () {
        Route::get('/', [MigrationController::class, 'index']);
        Route::post('/run', [MigrationController::class, 'run']);
        Route::post('/drop', [MigrationController::class, 'drop']);
        Route::post('/show', [MigrationController::class, 'show']);
    });
}else {
    Route::any('/migrations{any}', function ($any) {
        return view('errors/403', ['message' => 'Forbidden']);
    })->where('any', '.*');
}

Route::dispatch();