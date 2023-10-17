<?php

use App\Http\Controllers\Api\V1\ApplicationController;
use App\Http\Controllers\Api\V1\Auth\AuthenticationController;
use App\Http\Controllers\Api\V1\OwnerController;
use App\Http\Controllers\Api\V1\PreferenceController;
use App\Http\Controllers\Api\V1\PropertyController;
use App\Http\Controllers\Api\V1\TenantController;
use App\Http\Controllers\Api\V1\UserController;
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

    // Authentication routes
    Route::group(['prefix' => 'auth'], function () {
        Route::post('/register', [AuthenticationController::class, 'register'])->name('register');
        Route::post('/login', [AuthenticationController::class, 'login'])->name('login');
        Route::post('/logout', [AuthenticationController::class, 'logout'])->name('logout');
        Route::post('/refresh-token', [AuthenticationController::class, 'refresh'])->name('refresh_token');
    });

    // Upload avatar
    Route::post('/users/upload-avatar', [UploadController::class, 'userAvatar'])->middleware('auth')->name('upload.upload_avatar');

    // Property Preferences
    Route::resource('preferences', PreferenceController::class)->middleware(['auth', 'role:owner', 'role:renter']);

    // Archive Property Application
    Route::delete('/applications/{application}', [ApplicationController::class, 'archive'])->middleware(['auth', 'role:owner', 'role:renter'])->name('applications.archive');

    // ===== USER ROUTES ========= //
    Route::group(['prefix' => 'users', 'middleware' => ['auth', 'role:renter']], function () {
        // Update profile
        Route::put('update-profile', [UserController::class, 'updateProfile'])->name('users.update_profile');

        // Applications
        Route::post('properties/{property}/apply', [UserController::class, 'applyToProperty'])->name('users.apply_to_property');

        // Get one or all properties applications 
        Route::get('properties/applications/{property?}', [UserController::class, 'propertyApplications'])->name('users.property_applications');

        // Archive property's application
        Route::post('applications/{application}/archive', [UserController::class, 'archivePropertyApplication'])->name('users.archive_property_application');

        // Route::post('{tenant}/request-verification', [TenantController::class, 'requestVerification'])->name('tenants.request_verification');
    });


    // ===== ADMIN ROUTES ========= //
    Route::group(['prefix' => 'admin', 'middleware' => ['auth', 'role:admin']], function () {
        // Get All Owners
        Route::get('/owners', [OwnerController::class, 'index'])->name('admin.owners');

        // Get All Tenants
        Route::get('/tenants', [TenantController::class, 'index'])->name('admin.tenants');

        

        // Property applications
        Route::resource('applications', ApplicationController::class)->except('destroy');

        // Users
        Route::resource('users', UserController::class);
    });

    // ===== OWNER ROUTES ========= //
    Route::group(['prefix' => 'owners', 'middleware' => ['auth', 'role:owner']], function () {
        // Property routes
        Route::resource('properties', PropertyController::class);

        // Property
        Route::get('/my-properties', [OwnerController::class, 'myProperties'])->name('owner.my_properties');
        //Route::post('/create-property', [PropertyController::class, 'store'])->name('owner.create_property');
        //Route::put('/properties/{property}/update', [PropertyController::class, 'update'])->name('owner.update_property');
        //Route::delete('/properties/{property}/delete', [PropertyController::class, 'destroy'])->name('owner.destroy_property');
        Route::get('properties/applications/{property?}', [PropertyController::class, 'propertyApplications'])->name('owner.property_applications');
        Route::get('/properties/{property}/preferences', [PropertyController::class, 'preferences'])->name('owner.property_preferences');
        Route::post('/properties/{property}/change-status', [PropertyController::class, 'changeStatus'])->name('owner.property_change_status');
        Route::post('/properties/{property}/assign-tenant', [PropertyController::class, 'assignTenant'])->name('owner.property_assign_tenant');
        Route::get('/properties/{property}/get-tenant', [PropertyController::class, 'getTenant'])->name('owner.property_get_tenant');

        // Application
        Route::post('/applications/{application}/change-status', [ApplicationController::class, 'changeStatus'])->name('application.change_status');

        // Upload
        Route::post('/properties/{property}/upload-photos', [UploadController::class, 'uploadPropertyPhotos'])->name('upload.property_upload_photos');
        Route::post('/properties/{property}/delete-photos', [UploadController::class, 'deletePropertyPhotos'])->name('upload.property_delete_photos');
    });
});
