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
    });
});

