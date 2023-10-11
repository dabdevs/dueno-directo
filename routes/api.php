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

    // Authentication routes
    Route::group(['prefix' => 'auth'], function () {
        Route::post('/register', [AuthenticationController::class, 'register'])->name('register');
        Route::post('/login', [AuthenticationController::class, 'login'])->name('login');
        Route::post('/logout', [AuthenticationController::class, 'logout'])->name('logout');
        Route::post('/refresh-token', [AuthenticationController::class, 'refresh'])->name('refresh_token');
    });

    // ===== ADMIN ROUTES ========= //
    Route::middleware(['auth', 'role:admin'])->group(function () {
        // Get All Owners
        Route::get('/owners', [OwnerController::class, 'index'])->name('admin.owners');

        // Property routes
        Route::resource('properties', PropertyController::class);

        // Properties Preferences
        Route::resource('preferences', PreferenceController::class);
    });

    // Show property
    Route::get('properties/{property}', [PropertyController::class, 'show'])->name('properties.show');

    // ===== OWNER ROUTES ========= //
    Route::group(['prefix' => 'owners', 'middleware' => ['auth', 'role:owner']], function () {
        // Property
        Route::get('/properties', [OwnerController::class, 'myProperties'])->name('owner.properties');
        Route::post('/property/create', [PropertyController::class, 'store'])->name('properties.store');
        Route::put('/property/{property}/update', [PropertyController::class, 'update'])->name('properties.update');
        Route::delete('/property/{property}/delete', [PropertyController::class, 'destroy'])->name('properties.destroy');
        Route::get('/property-applications/{property}', [PropertyController::class, 'applications'])->name('properties.applications');
        Route::get('/property-preferences/{property}', [PropertyController::class, 'preferences'])->name('properties.preferences');
        Route::post('/property/{property}/change-status', [PropertyController::class, 'changeStatus'])->name('properties.change_status');
        Route::post('/property/{property}/assign-tenant', [PropertyController::class, 'assignTenant'])->name('properties.assign_tenant');
        Route::get('/property/{property}/get-tenant', [PropertyController::class, 'getTenant'])->name('properties.get_tenant');

        // Application
        Route::post('/applications/{application}/change-status', [ApplicationController::class, 'changeStatus'])->name('application.change_status');

        // Upload
        Route::post('/property/{property}/upload-photos', [UploadController::class, 'propertyUploadPhotos'])->name('upload.property_upload_photos');
        Route::post('/property/{property}/delete-photos', [UploadController::class, 'propertyDeletePhotos'])->name('upload.property_delete_photos');
    });

    // ===== TENANT ROUTES ========= //
    Route::group(['prefix' => 'tenants', 'middleware' => ['auth', 'role:tenant']], function () {
        // Application
        Route::resource('applications', ApplicationController::class);
        Route::get('{tenant}/applications', [TenantController::class, 'applications'])->name('tenants.applications');
        Route::post('{tenant}/request-verification', [TenantController::class, 'requestVerification'])->name('tenants.request_verification');
    });
});
