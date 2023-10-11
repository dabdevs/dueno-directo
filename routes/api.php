<?php

use App\Http\Controllers\Api\V1\ApplicationController;
use App\Http\Controllers\Api\V1\Auth\AuthenticationController;
use App\Http\Controllers\Api\V1\OwnerController;
use App\Http\Controllers\Api\V1\PreferenceController;
use App\Http\Controllers\Api\V1\PropertyController;
use App\Http\Controllers\Api\V1\TenantController;
use App\Http\Controllers\UploadController;
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

    // Property Preferences
    Route::resource('preferences', PreferenceController::class)->middleware(['auth', 'role:owner', 'role:tenant']);


    // Authentication routes
    Route::group(['prefix' => 'auth'], function () {
        Route::post('/register', [AuthenticationController::class, 'register'])->name('register');
        Route::post('/login', [AuthenticationController::class, 'login'])->name('login');
        Route::post('/logout', [AuthenticationController::class, 'logout'])->name('logout');
        Route::post('/refresh-token', [AuthenticationController::class, 'refresh'])->name('refresh_token');
    });

    // ===== ADMIN ROUTES ========= //
    Route::group(['prefix' => 'admin', 'middleware' => ['auth', 'role:admin']], function () {
        // Get All Owners
        Route::get('/owners', [OwnerController::class, 'index'])->name('admin.owners');

        // Get All Tenants
        Route::get('/tenants', [TenantController::class, 'index'])->name('admin.tenants');

        // Property routes
        Route::resource('properties', PropertyController::class);

    });

    // ===== OWNER ROUTES ========= //
    Route::group(['prefix' => 'owners', 'middleware' => ['auth', 'role:owner']], function () {
        // Property
        Route::get('/properties', [OwnerController::class, 'myProperties'])->name('owner.properties');
        Route::post('/properties/create', [PropertyController::class, 'store'])->name('properties.store');
        Route::put('/properties/{property}/update', [PropertyController::class, 'update'])->name('properties.update');
        Route::delete('/properties/{property}/delete', [PropertyController::class, 'destroy'])->name('properties.destroy');
        Route::get('/properties/{property}/applications', [PropertyController::class, 'applications'])->name('properties.applications');
        Route::get('/properties/{property}/preferences', [PropertyController::class, 'preferences'])->name('properties.preferences');
        Route::post('/properties/{property}/change-status', [PropertyController::class, 'changeStatus'])->name('properties.change_status');
        Route::post('/properties/{property}/assign-tenant', [PropertyController::class, 'assignTenant'])->name('properties.assign_tenant');
        Route::get('/properties/{property}/get-tenant', [PropertyController::class, 'getTenant'])->name('properties.get_tenant');

        // Application
        Route::post('/applications/{application}/change-status', [ApplicationController::class, 'changeStatus'])->name('application.change_status');

        // Upload
        Route::post('/properties/{property}/upload-photos', [UploadController::class, 'propertyUploadPhotos'])->name('upload.property_upload_photos');
        Route::post('/properties/{property}/delete-photos', [UploadController::class, 'propertyDeletePhotos'])->name('upload.property_delete_photos');
    });

    // ===== TENANT ROUTES ========= //
    Route::group(['prefix' => 'tenants', 'middleware' => ['auth', 'role:tenant']], function () {
        // Application
        Route::resource('applications', ApplicationController::class);
        Route::get('{tenant}/applications', [TenantController::class, 'applications'])->name('tenants.applications');
        Route::post('{tenant}/request-verification', [TenantController::class, 'requestVerification'])->name('tenants.request_verification');
    });
});
