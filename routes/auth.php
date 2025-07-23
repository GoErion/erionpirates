<?php

use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\Auth\VerifyEmailController;
use App\Livewire\Auth\ConfirmPassword;
use App\Livewire\Auth\ForgotPassword;
use App\Livewire\Auth\Login;
use App\Livewire\Auth\Register;
use App\Livewire\Auth\ResetPassword;
use App\Livewire\Auth\VerifyEmail;
use Illuminate\Support\Facades\Route;
use Laravel\Fortify\Http\Controllers\AuthenticatedSessionController as FortifyAuthenticatedSessionController;

Route::middleware('guest')->group(function () {
    Route::get('register', [RegisteredUserController::class,'create'])
        ->name('register');
    Route::post('register', [RegisteredUserController::class,'store']);

    Route::get('login', [AuthenticatedSessionController::class,'create'])
        ->name('login');
    Route::post('/login', [FortifyAuthenticatedSessionController::class,'store']);


    Route::get('forgot-password', ForgotPassword::class)->name('password.request');
    Route::get('reset-password/{token}', ResetPassword::class)->name('password.reset');
});

Route::middleware('auth')->group(function () {
    Route::post('logout', [AuthenticatedSessionController::class,'destroy'])
        ->name('logout');

});

