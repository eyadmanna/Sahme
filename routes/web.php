<?php

use App\Http\Controllers\Admin\RoleController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UsersController;
use Illuminate\Support\Facades\Route;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::group(
    [
        'prefix' => LaravelLocalization::setLocale(),
        'middleware' => [ 'localeSessionRedirect', 'localizationRedirect', 'localeViewPath' ]
    ], function(){ //...

    Route::get('/dashboard', function () {
        return view('admin.dashboard');
    })->middleware(['auth', 'verified'])->name('dashboard');

    Route::middleware('auth')->group(function () {
        Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
        Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
        Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
        Route::get('/users/list', [UsersController::class, 'index'])->name('users.index');
        Route::get('/users/getUsers', [UsersController::class, 'getUsers'])->name('users.getUsers');
        Route::post('/users/addUsers', [UsersController::class, 'store'])->name('users.store');
        Route::get('/users/view/{id}', [UsersController::class, 'view'])->name('users.view');
        Route::get('/roles', [RoleController::class,'index'])->name('roles.index');
        Route::get('/view-roles/{id}', [RoleController::class,'show'])->name('role.show');
        Route::post('/store-roles', [RoleController::class,'store'])->name('roles.store');
        Route::get('/edit-roles/{id}', [RoleController::class,'edit'])->name('roles.edit');
        Route::post('/update-roles/{id}', [RoleController::class,'update'])->name('roles.update');


    });


    require __DIR__.'/auth.php';


});



