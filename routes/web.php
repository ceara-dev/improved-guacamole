<?php

use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\ProfileController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\ResetPasswordController;
use App\Http\Controllers\PontoTuristicoController;
use Illuminate\Support\Facades\Route;

Route::get('/', [PontoTuristicoController::class, 'index'])->name('home');

// Auth
Route::middleware('guest')->group(function () {
    Route::get('login', [LoginController::class, 'create'])->name('login');
    Route::post('login', [LoginController::class, 'store']);
    Route::get('register', [RegisterController::class, 'create'])->name('register');
    Route::post('register', [RegisterController::class, 'store']);
    Route::get('forgot-password', [ForgotPasswordController::class, 'create'])->name('password.request');
    Route::post('forgot-password', [ForgotPasswordController::class, 'store'])->name('password.email');
    Route::get('reset-password/{token}', [ResetPasswordController::class, 'create'])->name('password.reset');
    Route::post('reset-password', [ResetPasswordController::class, 'store'])->name('password.update');
});

Route::middleware('auth')->group(function () {
    Route::post('logout', [LoginController::class, 'destroy'])->name('logout');
    Route::get('profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::post('profile/avatar', [ProfileController::class, 'updateAvatar'])->name('profile.avatar');
    Route::post('profile/password', [ProfileController::class, 'updatePassword'])->name('profile.password');
    Route::get('favoritos', [PontoTuristicoController::class, 'favoritos'])->name('favoritos');
});

Route::get('pontos-turisticos/{pontoTuristico}', [PontoTuristicoController::class, 'show'])
    ->name('pontos-turisticos.show');

Route::post('pontos-turisticos/{pontoTuristico}/favoritar', [PontoTuristicoController::class, 'toggleFavorito'])
    ->name('pontos-turisticos.favoritar');

Route::post('pontos-turisticos/{pontoTuristico}/curtir', [PontoTuristicoController::class, 'curtir'])
    ->name('pontos-turisticos.curtir');

Route::post('pontos-turisticos/{pontoTuristico}/descurtir', [PontoTuristicoController::class, 'descurtir'])
    ->name('pontos-turisticos.descurtir');

Route::post('pontos-turisticos/{pontoTuristico}/comentar', [PontoTuristicoController::class, 'comentar'])
    ->name('pontos-turisticos.comentar');

Route::get('pontos-turisticos/{pontoTuristico}/comentarios', [PontoTuristicoController::class, 'comentarios'])
    ->name('pontos-turisticos.comentarios');
