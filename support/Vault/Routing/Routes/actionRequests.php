<?php

use App\Controllers\DataUpdate\UserController;
use Support\Vault\Http\ActionRequests\Handlers\AccountActivationHandler;
use Support\Vault\Http\ActionRequests\Handlers\DataUpdateHandler;
use Support\Vault\Http\ActionRequests\Handlers\EmailVerificationHandler;
use Support\Vault\Http\ActionRequests\Handlers\PasswordResetHandler;
use Support\Vault\Routing\Route;

Route::prefix('action-request', function () {
    Route::get('/account-activation/{token}', [AccountActivationHandler::class, 'accountActivation']);
    Route::get('/email-verification/{token}', [EmailVerificationHandler::class, 'emailVerification']);
    Route::get('/password-reset/{token}', [PasswordResetHandler::class, 'requestCheck']);
    
});
Route::prefix('action-code', function () {
    Route::post('confirm/{token}', [DataUpdateHandler::class, 'updateData']);
    Route::prefix('user', function(){
        Route::put('/new-email', [UserController::class, 'newEmailRequest']);
    });
});