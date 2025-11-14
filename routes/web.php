<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CommissionController;

Route::get('/', function () {
    return redirect()->route('login');
});

Route::get('/commission', [CommissionController::class, 'index'])->name('commission.index');

Route::post('/commission/store', [CommissionController::class, 'store'])->name('commission.store');

Route::post('/commission/update/{id}', [CommissionController::class, 'update'])->name('commission.update');

Route::delete('/commission/delete/{id}', [CommissionController::class, 'destroy'])->name('commission.delete');
Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('register');
Route::post('/register', [AuthController::class, 'register'])->name('register.post');
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.post');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');
});
