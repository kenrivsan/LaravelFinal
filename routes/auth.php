<?php

use Illuminate\Support\Facades\Route;

use App\Livewire\Auth\Login;
use App\Livewire\Auth\RegisterUser;
use App\Livewire\Auth\ForgotPassword;
use App\Livewire\Auth\ResetPassword;
use App\Livewire\Auth\VerifyEmail;
use App\Livewire\Auth\ConfirmPassword;

use App\Http\Controllers\Auth\VerifyEmailController;
use App\Http\Controllers\Auth\AuthenticatedSessionController; // POST /login (respaldo)
use App\Http\Controllers\Auth\RegisteredUserController;       // POST /register (respaldo)

Route::middleware('guest')->group(function () {
    // Páginas Livewire
    Route::get('login', Login::class)->name('login');
    Route::get('register', RegisterUser::class)->name('register');
    Route::get('forgot-password', ForgotPassword::class)->name('password.request');
    Route::get('reset-password/{token}', ResetPassword::class)->name('password.reset');

    // Respaldos HTTP por si Livewire no intercepta el submit
    Route::post('login', [AuthenticatedSessionController::class, 'store'])->name('login.store');
    Route::post('register', [\App\Http\Controllers\Auth\RegisteredUserController::class, 'store'])
    ->name('register.store');
});

Route::middleware('auth')->group(function () {
    Route::get('verify-email', VerifyEmail::class)
        ->name('verification.notice');

    Route::get('verify-email/{id}/{hash}', VerifyEmailController::class)
        ->middleware(['signed', 'throttle:6,1'])
        ->name('verification.verify');

    Route::get('confirm-password', ConfirmPassword::class)
        ->name('password.confirm');
});

Route::post('logout', \App\Livewire\Actions\Logout::class)
    ->name('logout');