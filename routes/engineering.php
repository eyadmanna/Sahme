<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\EngineeringPartner\Auth\LoginController;
use App\Http\Controllers\EngineeringPartner\Auth\RegisterController;


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

        Route::post('logout', [LoginController::class, 'logout'])->name('logout');
    });
});




