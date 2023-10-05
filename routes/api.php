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

Route::group(['prefix' => 'v1'], function () {
    Route::get('health-check', function () {
        return response('OK', 200);
    })->name('health_check');

    // Search properties
    Route::get('search', [PropertyController::class, 'search'])->name('properties.search');
    
    // Show property
    Route::get('properties/{property}', [PropertyController::class, 'show'])->name('properties.show');

    // Authentication routes
    Route::group(['prefix' => 'auth'], function () {
        Route::post('/register', [AuthenticationController::class, 'register'])->name('register');
        Route::post('/login', [AuthenticationController::class, 'login'])->name('login');
        Route::post('/logout', [AuthenticationController::class, 'logout'])->name('logout');
        Route::post('/refresh-token', [AuthenticationController::class, 'refresh'])->name('refresh_token');
    });

    // ===== SECURE ROUTES ========= //
    Route::group(['middleware' => 'check_token'], function () {
        // User routes
        Route::resource('users', UserController::class);
        Route::get('my-properties', [UserController::class, 'myProperties'])->name('users.my_properties');
        Route::group(['prefix' => 'users'], function () {
            Route::get('{user}/profile', [UserController::class, 'profile'])->name('users.profile');
            Route::delete('{user?}/profile/delete', [UserController::class, 'deleteProfile'])->name('users.delete_profile');
            Route::post('upload-avatar', [UserController::class, 'uploadAvatar'])->name('users.upload_avatar');
        });

        // Tenant routes
        Route::resource('/tenants', TenantController::class)->middleware('role:tenant');
        Route::group(['prefix' => 'tenants', 'middleware' => 'role:tenant'], function () {
            Route::get('{tenant}/applications', [TenantController::class, 'applications'])->name('tenants.applications');
            Route::post('{tenant}/request-verification', [TenantController::class, 'requestVerification'])->name('tenants.request_verification');
        });

        // Property routes
        Route::resource('properties', PropertyController::class)->except('show');
        Route::group(['prefix' => 'properties'], function () {
            Route::get('{property}/applications', [PropertyController::class, 'applications'])->name('properties.applications');
            Route::get('{property}/preferences', [PropertyController::class, 'preferences'])->name('properties.preferences');
            Route::post('{property}/assign-tenant', [PropertyController::class, 'assignTenant'])->name('properties.assign_tenant');
            Route::get('{property}/tenant', [PropertyController::class, 'getTenant'])->name('properties.get_tenant');
        });

        // Properties Preferences
        Route::resource('preferences', PreferenceController::class)->middleware('role:owner');

        // Application routes
        Route::resource('applications', ApplicationController::class)->middleware('role:tenant');
        Route::post('applications/{application}/change-status', [ApplicationController::class, 'changeStatus'])->middleware('role:owner')->name('applications.change_status');

        // VerificationRequest routes
        Route::resource('verification-requests', VerificationRequestController::class);
        Route::post('/verification-requests/{verification_request}/change-status', [VerificationRequestController::class, 'changeStatus'])->middleware('role:admin')->name('verification_requests.change_status');
    });
});
