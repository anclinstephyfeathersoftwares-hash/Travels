<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CommissionController;

use App\Http\Controllers\CancelRequestController;


Route::get('/', function () {
    return redirect()->route('login');
});


// Commission Routes
Route::get('/commission', [CommissionController::class, 'index'])->name('commission.index');

// Create (Add)
Route::get('/commission/create', [CommissionController::class, 'create'])->name('commission.create');
Route::post('/commission/store', [CommissionController::class, 'store'])->name('commission.store');

// Edit
Route::get('/commission/edit/{id}', [CommissionController::class, 'edit'])->name('commission.edit');
Route::post('/commission/update/{id}', [CommissionController::class, 'update'])->name('commission.update');

// Delete
Route::delete('/commission/delete/{id}', [CommissionController::class, 'destroy'])->name('commission.delete');


Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('register');
Route::post('/register', [AuthController::class, 'register'])->name('register.post');
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.post');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

Route::get('/cancel-request', [CancelRequestController::class, 'index'])->name('cancel.index');
Route::post('/cancel-request/store', [CancelRequestController::class, 'store'])->name('cancel.store');

Route::get('/cancel-request/edit/{id}', [CancelRequestController::class, 'edit'])->name('cancel.edit');
Route::post('/cancel-request/update/{id}', [CancelRequestController::class, 'update'])->name('cancel.update');

Route::delete('/cancel-request/delete/{id}', [CancelRequestController::class, 'destroy'])->name('cancel.delete');


Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');
});
