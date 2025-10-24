<?php

use App\Livewire\Settings\Appearance;
use App\Livewire\Settings\Password;
use App\Livewire\Settings\Profile;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PageController;
use App\Http\Controllers\QuestionController;
use App\Http\Controllers\AnswerController;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;

// Públicas
Route::get('/', [PageController::class, 'index'])->name('home');
Route::get('/question/{question}', [QuestionController::class, 'show'])->name('question.show');
Route::post('/answers/{question}', [\App\Http\Controllers\AnswerController::class, 'store'])->name('answers.store');

// Rutas de autenticación (login y register)
Route::middleware('guest')->group(function () {
    // Usamos Livewire para el Login y Registro
    Route::get('login', \App\Livewire\Auth\Login::class)->name('login');
    Route::get('register', \App\Livewire\Auth\RegisterUser::class)->name('register');  
    
    // Si usas controladores para manejar el login tradicional
    Route::post('login', [AuthenticatedSessionController::class, 'store'])->name('login.post');
    Route::post('register', [RegisteredUserController::class, 'store'])->name('register.post');
});

// Protegidas: crear/editar/actualizar/eliminar preguntas
Route::middleware(['auth','verified'])->group(function () {
    Route::get('/questions/create', [QuestionController::class, 'create'])->name('questions.create');
    Route::post('/questions', [QuestionController::class, 'store'])->name('questions.store');

    Route::get('/questions/{question}/edit', [QuestionController::class, 'edit'])
        ->name('questions.edit')
        ->can('update','question');

    Route::match(['put','patch'], '/questions/{question}', [QuestionController::class, 'update'])
        ->name('questions.update')
        ->can('update','question');

    Route::delete('/questions/{question}', [QuestionController::class, 'destroy'])
        ->name('questions.destroy')
        ->can('delete','question');
});

// Dashboard
Route::get('dashboard', function () {
    return redirect()->route('home');
})->middleware(['auth', 'verified'])->name('dashboard');

// Settings
Route::middleware(['auth'])->group(function () {
    Route::redirect('settings', 'settings/profile');
    Route::get('settings/profile', Profile::class)->name('settings.profile');
    Route::get('settings/password', Password::class)->name('settings.password');
    Route::get('settings/appearance', Appearance::class)->name('settings.appearance');
});

require __DIR__.'/auth.php';
