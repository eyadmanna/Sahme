<?php

use App\Http\Controllers\Admin\AttachmentController;
use App\Http\Controllers\Admin\LandsController;
use App\Http\Controllers\Admin\ProjectController;
use App\Http\Controllers\Admin\EngineeringController;
use App\Http\Controllers\Admin\RoleController;
use App\Http\Controllers\Admin\TwoFactorController;
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

    Route::middleware( 'auth')->group(function () {
        Route::get('/MyProfile', [ProfileController::class, 'view'])->name('profile.view');
        Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
        Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');


        Route::get('/users/list', [UsersController::class, 'index'])->name('users.index');
        Route::get('/users/getUsers', [UsersController::class, 'getUsers'])->name('users.getUsers');
        Route::post('/users/addUsers', [UsersController::class, 'store'])->name('users.store');
        Route::get('/users/view/{id}', [UsersController::class, 'view'])->name('users.view');
        Route::post('/users/update/{id}', [UsersController::class, 'update'])->name('users.update');
        Route::delete('/users/delete/{id}', [UsersController::class, 'destroy'])->name('users.destroy');


        Route::get('/roles', [RoleController::class,'index'])->name('roles.index');
        Route::get('/view-roles/{id}', [RoleController::class,'show'])->name('role.show');
        Route::post('/store-roles', [RoleController::class,'store'])->name('roles.store');
        Route::get('/edit-roles/{id}', [RoleController::class,'edit'])->name('roles.edit');
        Route::post('/update-roles/{id}', [RoleController::class,'update'])->name('roles.update');




        Route::get('/admin/investor-details', [App\Http\Controllers\Admin\InvestorsController::class, 'getInvestorDetails'])->name('admin.getInvestorDetails');


        Route::get('/lands/list', [LandsController::class, 'index'])->name('lands.index');
        Route::get('/lands/getLands', [LandsController::class, 'getLands'])->name('lands.getLands');
        Route::get('/lands/add-land', [LandsController::class, 'add'])->name('lands.add');
        Route::post('/lands/store-land', [LandsController::class,'store'])->name('lands.store');
        Route::get('/lands/edit-land/{id}', [LandsController::class,'edit'])->name('lands.edit');
        Route::delete('/attachments/{id}', [AttachmentController::class, 'destroy'])->name('attachments.destroy');
        Route::post('/lands/update-land/{id}', [LandsController::class,'update'])->name('lands.update');
        Route::get('/lands/view-land/{id}', [LandsController::class,'view'])->name('lands.view');
        Route::get('/lands/approval-legal-ownership/{id}', [LandsController::class,'approval_legal_ownership'])->name('lands.approval_legal_ownership');
        Route::get('/lands/approval-valuation-ownership/{id}', [LandsController::class,'approval_valuation_ownership'])->name('lands.approval_valuation_ownership');
        Route::post('/lands/approval-valuation-ownership/{id}', [LandsController::class,'approval_valuation_ownership'])->name('lands.approval_valuation_ownership');
        Route::post('/lands/approval-legal-ownership/{id}', [LandsController::class,'approval_legal_ownership'])->name('lands.approval_legal_ownership');
        Route::post('/lands/upload-legal-attachment/{id}', [LandsController::class, 'upload_legal_attachment'])->name('lands.upload_legal_attachment');
        Route::post('/lands/delete-attachment', [LandsController::class, 'delete_attachment'])->name('lands.delete_attachment');

        Route::get('/projects/list', [ProjectController::class, 'index'])->name('projects.index');
        Route::get('/projects/getProjects', [ProjectController::class, 'getProjects'])->name('projects.getProjects');
        Route::get('/projects/add-project/{land_id?}', [ProjectController::class, 'add'])->name('projects.add');
        Route::get('/projects/view-project/{id}', [ProjectController::class, 'view'])->name('projects.view');
        Route::get('/projects/edit-project/{id}', [ProjectController::class, 'edit'])->name('projects.edit');
        Route::post('/projects/update-project/{id}', [ProjectController::class,'update'])->name('projects.update');
        Route::get('/projects/engineering-consultant-evaluation/{id}', [ProjectController::class,'engineering_consultant_evaluation'])->name('projects.engineering_consultant_evaluation');
        Route::post('/projects/engineering-consultant-evaluation/{id}', [ProjectController::class,'engineering_consultant_evaluation'])->name('projects.engineering_consultant_evaluation');
        Route::get('/projects/land_filter', [ProjectController::class, 'land_filter'])->name('projects.land_filter');

        Route::post('/projects/store-details', [ProjectController::class, 'store'])->name('projects.store');
        Route::get('/land/land-details', [LandsController::class, 'getLandDetails'])->name('land.getLandDetails');



        Route::get('/engineering_partners/list', [EngineeringController::class, 'index'])->name('engineering_partners.index');
        Route::get('/engineering_partners/get_engineering_partners', [EngineeringController::class, 'get_engineering_partners'])->name('get_engineering_partners');
        Route::get('/engineering_partners/create', [EngineeringController::class, 'create'])->name('engineering_partners.create');
        Route::post('/engineering_partners/store', [EngineeringController::class, 'store'])->name('engineering_partners.store');
        Route::get('/engineering_partners/profile/{id}', [EngineeringController::class, 'profile'])->name('engineering_partners.profile');
        Route::get('/engineering_partners/profile/settings/{id}', [EngineeringController::class, 'profile_settings'])->name('engineering_partners.settings');
        Route::post('/engineering_partners/profile/update_settings/{id}', [EngineeringController::class, 'update_settings'])->name('engineering_partners.update_settings');
        Route::post('/engineering_partners/profile/update-password', [EngineeringController::class, 'update_password'])->name('engineering_partners.profile.update-password');
        Route::post('/engineering_partners/accredit/{id}', [EngineeringController::class, 'accredit'])->name('engineering_partners.accredit');
        Route::post('engineering-partners/{id}/reject', [EngineeringController::class, 'reject'])->name('engineering_partners.reject');



    });




    require __DIR__.'/auth.php';


});



