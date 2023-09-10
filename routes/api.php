<?php

use App\Http\Controllers\Api\V1\ApplicationController;
use App\Http\Controllers\Api\V1\Auth\AuthenticationController;
use App\Http\Controllers\Api\V1\ListingController;
use App\Http\Controllers\Api\V1\PreferenceController;
use App\Http\Controllers\Api\V1\PropertyController;
use App\Http\Controllers\Api\V1\TenantController;
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
        Route::get('users/{user}/profile', [UserController::class, 'profile'])->name('user_profile');
        Route::delete('users/{user?}/profile/delete', [UserController::class, 'deleteProfile'])->name('user_delete_profile');
        Route::get('users/{user}/properties', [UserController::class, 'properties'])->name('properties');

        // Tenant routes
        Route::resource('/tenants', TenantController::class);
        Route::get('tenants/{tenant}/applications', [TenantController::class, 'applications'])->name('tenant_applications');
        
        // Property routes
        Route::resource('properties', PropertyController::class);
        Route::get('properties/{property}/applications', [PropertyController::class, 'applications'])->name('property_applications');
        Route::get('properties/{property}/preferences', [PropertyController::class, 'preferences'])->name('property_preferences');
        Route::post('properties/{property}/assign-tenant', [PropertyController::class, 'assignTenant'])->name('assign_tenant');

        // Property preferences
        Route::resource('preferences', PreferenceController::class);

        // Application routes
        Route::resource('applications', ApplicationController::class);

        // Owner routes
        // Route::resource('/listings', ListingController::class); 
    });
});
