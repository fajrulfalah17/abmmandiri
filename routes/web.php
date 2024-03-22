<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

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
    return view('auth.login');
});

Auth::routes();

Route::prefix('admin')->group(function() {
    Route::group(['middleware' => 'auth'], function() {
        Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home'); 

        Route::get('/dashboard', [App\Http\Controllers\DashboardController::class, 'index'])->name('dashboard');
        Route::get('/permission', [App\Http\Controllers\PermissionController::class, 'index'])->name('permission');
        Route::resource('/roles', App\Http\Controllers\RoleController::class);
        Route::resource('/user-admin', App\Http\Controllers\UserController::class);
        Route::resource('/user-madrasah', App\Http\Controllers\UserMadrasahController::class);

        Route::resource('/madrasah', App\Http\Controllers\MadrasahController::class);
        Route::get('/details-madrasah/{id}', [App\Http\Controllers\MadrasahController::class, 'details'])->name('details-madrasah');
        Route::put('/details-madrasah/{id}/update', [App\Http\Controllers\MadrasahController::class, 'updateDetails'])->name('madrasah.updateDetails');

        Route::get('/pelaksanaan-madrasah/{id}', [App\Http\Controllers\MadrasahController::class, 'mora'])->name('mora-madrasah');
        Route::put('/pelaksanaan-madrasah/{id}/update', [App\Http\Controllers\MadrasahController::class, 'updateMora'])->name('madrasah.updateMora');

        Route::get('/rdm-madrasah/{id}', [App\Http\Controllers\MadrasahController::class, 'rdm'])->name('rdm-madrasah');
        Route::put('/rdm-madrasah/{id}/update', [App\Http\Controllers\MadrasahController::class, 'updateRdm'])->name('madrasah.updateRdm');

        Route::resource('/pengumuman', App\Http\Controllers\PengumumanController::class);
    });
});

