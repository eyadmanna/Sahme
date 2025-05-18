<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\EngineeringPartner\Auth\LoginController;
use App\Http\Controllers\EngineeringPartner\Auth\RegisterController;
use App\Http\Controllers\EngineeringPartner\LookupsController;
use App\Http\Controllers\EngineeringPartner\EngineeringController;

Route::post('lookups/get_children_by_parent', [LookupsController::class, 'get_children_by_parent'])->name('get_children_by_parent');

Route::prefix('engineering')->name('engineering.')->group(function () {
    Route::middleware('guest:engineering')->group(function () {
        Route::get('login', [LoginController::class, 'showLoginForm'])->name('login');
        Route::post('login', [LoginController::class, 'login']);
        Route::get('register', [RegisterController::class, 'showRegisterForm'])->name('register');
        Route::post('register', [RegisterController::class, 'register']);
    });

    Route::middleware('auth:engineering')->group(function () {
        Route::get('dashboard', function () {
            return view('engineering_partner.dashboard');
        })->name('dashboard');
        Route::get('profile', [EngineeringController::class, 'profile'])->name('profile');
        Route::get('profile/settings', [EngineeringController::class, 'profile_settings'])->name('profile.settings');
        Route::post('profile/update', [EngineeringController::class, 'update_profile_settings'])->name('profile.update');
        Route::post('profile/update-password', [EngineeringController::class, 'update_password'])->name('profile.update-password');
        Route::post('logout', [LoginController::class, 'logout'])->name('logout');
    });
});




