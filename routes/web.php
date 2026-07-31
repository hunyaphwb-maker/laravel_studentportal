<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProfileController;
use App\Http\Middleware\EnforceSessionTimeout;
use App\Http\Middleware\EnsureAuthenticated;
use App\Http\Middleware\RedirectIfAuthenticated;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('home');
})->name('home');

Route::middleware([RedirectIfAuthenticated::class])->group(function (): void {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login'])->name('login.attempt');
    Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [AuthController::class, 'register'])->name('register.store');
});

Route::middleware([EnsureAuthenticated::class, EnforceSessionTimeout::class])->group(function (): void {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::post('/profiles', [ProfileController::class, 'store'])->name('profiles.store');
    Route::get('/profiles/{profile}/edit', [ProfileController::class, 'edit'])->name('profiles.edit');
    Route::put('/profiles/{profile}', [ProfileController::class, 'update'])->name('profiles.update');
    Route::delete('/profiles/{profile}', [ProfileController::class, 'destroy'])->name('profiles.destroy');
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
});
