<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CommissionController;
use App\Http\Controllers\CancelRequestController;
use App\Http\Controllers\CompanyController;
use App\Http\Controllers\SettingsController;




Route::get('/', function () {
    return redirect()->route('company.setup');
});



Route::get('/setup', [CompanyController::class, 'index'])->name('company.setup');
Route::post('/setup', [CompanyController::class, 'store'])->name('company.store');

Route::get('/select-role', function () {
    return view('select-role');
})->name('select.role');



Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('register');
Route::post('/register', [AuthController::class, 'register'])->name('register.post');

Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.post');

Route::post('/logout', [AuthController::class, 'logout'])->name('logout');


Route::middleware(['auth'])->group(function () {

    // Dashboard
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');
Route::get('/settings', [SettingsController::class, 'index'])->name('settings');

    Route::post('/settings/profile', [SettingsController::class, 'updateProfileImage'])->name('settings.profile');

    Route::post('/settings/company', [SettingsController::class, 'updateCompanyImage'])->name('settings.company');

    Route::post('/settings/account', [SettingsController::class, 'updateAccount'])->name('settings.account');

    Route::delete('/settings/delete', [SettingsController::class, 'deleteAccount'])->name('settings.delete');
   

    Route::get('/commission', [CommissionController::class, 'index'])->name('commission.index');

    Route::get('/commission/create', [CommissionController::class, 'create'])->name('commission.create');
    Route::post('/commission/store', [CommissionController::class, 'store'])->name('commission.store');

    Route::get('/commission/edit/{id}', [CommissionController::class, 'edit'])->name('commission.edit');
    Route::post('/commission/update/{id}', [CommissionController::class, 'update'])->name('commission.update');

    Route::delete('/commission/delete/{id}', [CommissionController::class, 'destroy'])->name('commission.delete');

    Route::get('/cancel-request', [CancelRequestController::class, 'index'])->name('cancel.index');
    Route::post('/cancel-request/store', [CancelRequestController::class, 'store'])->name('cancel.store');

    Route::get('/cancel-request/edit/{id}', [CancelRequestController::class, 'edit'])->name('cancel.edit');
    Route::post('/cancel-request/update/{id}', [CancelRequestController::class, 'update'])->name('cancel.update');

    Route::delete('/cancel-request/delete/{id}', [CancelRequestController::class, 'destroy'])->name('cancel.delete');

});
