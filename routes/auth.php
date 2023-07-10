<?php

use App\Http\Controllers\Api\AuthController;

Route::controller(AuthController::class)->group(function () {
    Route::post('login', 'login')->name('auth-login');
    Route::post('password/reset', 'resetPassword')->name('auth-reset-password');
    Route::post('password/forgot', 'forgotPassword')->name('auth-forgot-password');
});
