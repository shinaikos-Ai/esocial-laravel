<?php

use App\Http\Controllers\ExtratorController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::get('/', fn () => redirect()->route('login'));

Route::middleware(['auth'])->group(function () {

    // Dashboard → redireciona para o extrator
    Route::get('/dashboard', fn () => redirect()->route('extrator.index'))->name('dashboard');

    // Extrator eSocial (todos os usuários autenticados)
    Route::get('/extrator', [ExtratorController::class, 'index'])->name('extrator.index');

    // Gestão de usuários (apenas admin)
    Route::middleware('admin')->resource('users', UserController::class);
});

require __DIR__.'/auth.php';
