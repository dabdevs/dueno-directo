<?php

use App\Http\Controllers\Api\V1\Auth\AuthenticationController;
use App\Http\Controllers\Api\V1\ListingController;
use App\Http\Controllers\Api\V1\UserController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

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

Route::group(['prefix' => 'v1'], function () {
    Route::get('health-check', function () {
        return response('OK', 200);
    });

    // Authentication routes
    Route::group(['prefix' => 'auth'], function () {
        Route::post('/register', [AuthenticationController::class, 'register']);
        Route::post('/login', [AuthenticationController::class, 'login']);
        Route::post('/refresh', [AuthenticationController::class, 'refresh']); 
    });

    // Secure routes
    Route::group(['middleware' => 'check_token'], function () {
        // User routes
        Route::resource('users', UserController::class);

        // Owner routes
        Route::group(['middleware' => 'admin', 'prefix' => 'owners'], function () {
            Route::resource('/listings', ListingController::class); 
        });

        // Tenant routes
        // Route::prefix('tenant')->group(function () {
        //     Route::resource('/profile', TenantController::class);
        // });

        // Route::get('/dashboard', [DashboardController::class, 'index'])->middleware(['auth'])->name('dashboard');
        // Route::post('/register-user-type', [DashboardController::class, 'registerUserType'])->middleware(['auth'])->name('auth.register_user_type');


    });
});
