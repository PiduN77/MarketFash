<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MainController;
use App\Http\Controllers\OtpController;

Auth::routes(['verify' => true]);

Route::prefix('otp')->group(function () {
    Route::get('/verify', [OtpController::class, 'showVerifyForm'])->name('otp.verify');
    Route::post('/verify/user', [OtpController::class, 'verify'])->name('otp.verifyUser');
});

Route::controller(MainController::class)->group(function () {
    Route::get('/', 'index')->name('index');
    Route::get('/product/{id}',  'show')->name('product.show');
});

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
