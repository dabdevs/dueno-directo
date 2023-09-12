<?php

use App\Http\Controllers\Api\V1\ApplicationController;
use App\Http\Controllers\Api\V1\Auth\AuthenticationController;
use App\Http\Controllers\Api\V1\ListingController;
use App\Http\Controllers\Api\V1\PreferenceController;
use App\Http\Controllers\Api\V1\PropertyController;
use App\Http\Controllers\Api\V1\TenantController;
use App\Http\Controllers\Api\V1\UserController;
use App\Http\Controllers\Api\V1\VerificationRequestController;
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
    })->name('health_check');

    // Authentication routes
    Route::group(['prefix' => 'auth'], function () {
        Route::post('/register', [AuthenticationController::class, 'register'])->name('register');
        Route::post('/login', [AuthenticationController::class, 'login'])->name('login');
        Route::post('/refresh-token', [AuthenticationController::class, 'refresh'])->name('refresh_token');
    });

    // Secure routes
    Route::group(['middleware' => 'check_token'], function () {
        // User routes
        Route::resource('users', UserController::class)->middleware('role:admin');
        Route::group(['prefix' => 'users'], function () {
            Route::get('{user}/profile', [UserController::class, 'profile'])->name('users.profile');
            Route::delete('{user?}/profile/delete', [UserController::class, 'deleteProfile'])->name('users.delete_profile');
            Route::get('{user}/properties', [UserController::class, 'properties'])->name('users.properties');
        });

        // Tenant routes
        Route::resource('/tenants', TenantController::class)->middleware('role:tenant', 'role:admin');
        Route::group(['prefix' => 'tenants', 'middleware' => ['role:admin', 'role:tenant']], function () {
            Route::get('{tenant}/applications', [TenantController::class, 'applications'])->name('tenants.applications');
            Route::post('{tenant}/request-verification', [TenantController::class, 'requestVerification'])->name('tenants.request_verification');
        });

        // Property routes
        Route::resource('properties', PropertyController::class);
        Route::get('search', [PropertyController::class, 'search'])->name('properties.search');
        Route::group(['prefix' =>'properties', 'middleware' => ['role:owner', 'role:admin']], function () {
            Route::get('{property}/applications', [PropertyController::class, 'applications'])->name('properties.applications');
            Route::get('{property}/preferences', [PropertyController::class, 'preferences'])->name('properties.preferences');
            Route::post('{property}/assign-tenant', [PropertyController::class, 'assignTenant'])->name('properties.assign_tenant');
            Route::get('{property}/tenant', [PropertyController::class, 'tenant'])->name('properties.tenant');
        });

        // Properties Preferences
        Route::resource('preferences', PreferenceController::class)->middleware('role:admin', 'role:owner');

        // Application routes
        Route::resource('applications', ApplicationController::class)->middleware('role:tenant', 'role:admin');
        Route::post('applications/{application}/change-status', [ApplicationController::class, 'changeStatus'])->middleware('role:owner')->name('applications.change_status');

        // VerificationRequest routes
        Route::resource('/verification-requests', VerificationRequestController::class)->middleware('role:admin', 'role:owner', 'role:tenant');
    });
});
