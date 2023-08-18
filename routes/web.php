<?php

use App\Http\Controllers\Auth\DashboardController;
use App\Http\Controllers\OwnerController;
use App\Http\Controllers\TenantController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});


require __DIR__.'/auth.php';

// Route::middleware('auth')->group(function () {
//     // Admin routes
//     Route::prefix('admin')->group(function () { 
//         Route::resource('users', UserController::class);
//     });

//     // Owner routes
//     Route::prefix('owner')->group(function () {
//         Route::resource('/profile', OwnerController::class);
//     });

//     // Tenant routes
//     Route::prefix('tenant')->group(function () {
//         Route::resource('/profile', TenantController::class);
//     });

//     Route::get('/dashboard', [DashboardController::class, 'index'])->middleware(['auth'])->name('dashboard');
//     Route::post('/register-user-type', [DashboardController::class, 'registerUserType'])->middleware(['auth'])->name('auth.register_user_type');
// });
