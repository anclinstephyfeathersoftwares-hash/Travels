<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CommissionController;
use App\Http\Controllers\CancelRequestController;
use App\Http\Controllers\CompanyController;
use App\Http\Controllers\SettingsController;
use App\Http\Controllers\BusController;

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

// Auth Routes
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

    // Settings
       // Settings main page
    Route::get('/settings', [SettingsController::class, 'index'])->name('settings.index');

    // Update profile image
    Route::post('/settings/profile', [SettingsController::class, 'updateProfileImage'])
        ->name('settings.profile');

    // Update company logo
    Route::post('/settings/company-logo', [SettingsController::class, 'updateCompanyImage'])
        ->name('settings.companyLogo');

    // Update company details
    Route::post('/settings/company-details', [SettingsController::class, 'updateCompanyDetails'])
        ->name('settings.companyDetails');

    // Update username + password
    Route::post('/settings/account', [SettingsController::class, 'updateAccount'])
        ->name('settings.account');

    // Delete account
    Route::delete('/settings/delete', [SettingsController::class, 'deleteAccount'])
        ->name('settings.delete');


    // Commission
    Route::get('/commission', [CommissionController::class, 'index'])->name('commission.index');
    Route::get('/commission/create', [CommissionController::class, 'create'])->name('commission.create');
    Route::post('/commission/store', [CommissionController::class, 'store'])->name('commission.store');
    Route::get('/commission/edit/{id}', [CommissionController::class, 'edit'])->name('commission.edit');
    Route::post('/commission/update/{id}', [CommissionController::class, 'update'])->name('commission.update');
    Route::delete('/commission/delete/{id}', [CommissionController::class, 'destroy'])->name('commission.delete');

    // Cancel Request
    Route::get('/cancel-request', [CancelRequestController::class, 'index'])->name('cancel.index');
    Route::post('/cancel-request/store', [CancelRequestController::class, 'store'])->name('cancel.store');
    Route::get('/cancel-request/edit/{id}', [CancelRequestController::class, 'edit'])->name('cancel.edit');
    Route::post('/cancel-request/update/{id}', [CancelRequestController::class, 'update'])->name('cancel.update');
    Route::delete('/cancel-request/delete/{id}', [CancelRequestController::class, 'destroy'])->name('cancel.delete');

    // -------------------------
// BUS MODULE ROUTES
// -------------------------
Route::prefix('bus')->group(function () {

    // Existing routes
    Route::get('/search', [BusController::class, 'index'])->name('bus.search.form');
    Route::post('/search', [BusController::class, 'search'])->name('bus.search.post');
    Route::get('/bus/passenger/add-global', [BusController::class, 'createPassengerGlobal'])->name('passenger.add_global');


    Route::get('/bus/add', [BusController::class, 'createPassengerGlobal'])->name('passenger.create.global');
    Route::post('/passenger/store', [BusController::class, 'storePassenger'])->name('passenger.store');

    Route::get('/available', [BusController::class, 'availableByDate'])->name('bus.available');

    Route::get('/schedule/{schedule}/book', [BusController::class, 'book'])->name('bus.book');
    Route::post('/booking/store', [BusController::class, 'storeBooking'])->name('bus.storeBooking');

    Route::get('/ticket/{ref}/pdf', [BusController::class, 'ticketPdf'])->name('bus.ticket.pdf');
    Route::get('/ticket/{ref}', [BusController::class, 'ticket'])->name('bus.ticket');

    // ✅ NEW GLOBAL ADD PASSENGER ROUTE
    Route::get('/add', [BusController::class, 'createPassengerGlobal'])->name('passenger.create.global');
});

});// <-- crucial closing brace and parenthesis
