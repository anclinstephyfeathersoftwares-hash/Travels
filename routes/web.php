<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CommissionController;
use App\Http\Controllers\CancelRequestController;
use App\Http\Controllers\CompanyController;
use App\Http\Controllers\SettingsController;
use App\Http\Controllers\BusController;
use App\Http\Controllers\DashboardController;

/*
|--------------------------------------------------------------------------
| Public Routes
|--------------------------------------------------------------------------
*/

Route::get('/', function () {
    return redirect()->route('company.setup');
});

// Company Setup
Route::get('/setup', [CompanyController::class, 'index'])->name('company.setup');
Route::post('/setup', [CompanyController::class, 'store'])->name('company.store');

// Role Select
Route::get('/select-role', function () {
    return view('select-role');
})->name('select.role');

// Auth
Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('register');
Route::post('/register', [AuthController::class, 'register'])->name('register.post');

Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.post');

Route::post('/logout', [AuthController::class, 'logout'])->name('logout');


/*
|--------------------------------------------------------------------------
| Authenticated Routes
|--------------------------------------------------------------------------
*/

Route::middleware('auth')->group(function () {

    // Main Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])
        ->name('dashboard');

    /*
    |-------------------
    | Settings
    |-------------------
    */
    Route::get('/settings', [SettingsController::class, 'index'])->name('settings.index');
    Route::post('/settings/profile', [SettingsController::class, 'updateProfileImage'])->name('settings.profile');
    Route::post('/settings/company-logo', [SettingsController::class, 'updateCompanyImage'])->name('settings.companyLogo');
    Route::post('/settings/company-details', [SettingsController::class, 'updateCompanyDetails'])->name('settings.companyDetails');
    Route::post('/settings/account', [SettingsController::class, 'updateAccount'])->name('settings.account');
    Route::delete('/settings/delete', [SettingsController::class, 'deleteAccount'])->name('settings.delete');

    /*
    |-------------------
    | Commission
    |-------------------
    */
    Route::get('/commission', [CommissionController::class, 'index'])->name('commission.index');
    Route::get('/commission/create', [CommissionController::class, 'create'])->name('commission.create');
    Route::post('/commission', [CommissionController::class, 'store'])->name('commission.store');
    Route::get('/commission/{id}/edit', [CommissionController::class, 'edit'])->name('commission.edit');
    Route::put('/commission/{id}', [CommissionController::class, 'update'])->name('commission.update');
    Route::delete('/commission/{id}', [CommissionController::class, 'destroy'])->name('commission.delete');

    /*
    |-------------------
    | Cancel Requests
    |-------------------
    */
    Route::get('/cancel-request', [CancelRequestController::class, 'index'])->name('cancel.index');
    Route::post('/cancel-request', [CancelRequestController::class, 'store'])->name('cancel.store');
    Route::get('/cancel-request/{id}/edit', [CancelRequestController::class, 'edit'])->name('cancel.edit');
    Route::put('/cancel-request/{id}', [CancelRequestController::class, 'update'])->name('cancel.update');
    Route::delete('/cancel-request/{id}', [CancelRequestController::class, 'destroy'])->name('cancel.delete');

    /*
    |-------------------
    | Bus Module
    |-------------------
    */
    Route::prefix('bus')->group(function () {

        // Search & Availability
        Route::get('/search', [BusController::class, 'index'])->name('bus.search.form');
        Route::post('/search', [BusController::class, 'search'])->name('bus.search.post');
        Route::get('/available', [BusController::class, 'availableByDate'])->name('bus.available');

        // Passenger (GLOBAL)
        Route::get('/passenger/add', [BusController::class, 'createPassengerGlobal'])
            ->name('passenger.create.global');
        Route::post('/passenger/store', [BusController::class, 'storePassenger'])
            ->name('passenger.store');

        // Booking
        Route::get('/schedule/{schedule}/book', [BusController::class, 'book'])->name('bus.book');
        Route::post('/booking/store', [BusController::class, 'storeBooking'])->name('bus.storeBooking');

        // Ticket
        Route::get('/ticket/{ref}', [BusController::class, 'ticket'])->name('bus.ticket');
        Route::get('/ticket/{ref}/pdf', [BusController::class, 'ticketPdf'])->name('bus.ticket.pdf');

    });

});
