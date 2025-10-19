<?php

use App\Http\Controllers\SuperAdmin\IndexController;
use App\Http\Controllers\SuperAdmin\Privileges\PermissionsController;
use App\Http\Controllers\SuperAdmin\Privileges\RolesController;
use App\Http\Controllers\SuperAdmin\Profile\PasswordController;
use App\Http\Controllers\SuperAdmin\Profile\ProfileController;
use App\Http\Controllers\SuperAdmin\SettingsController;
use App\Http\Controllers\SuperAdmin\UsersController;
use Illuminate\Support\Facades\Route;

Route::prefix('super-admin')->name('super-admin.')->group(function () {

    Route::get('/', [IndexController::class, 'index'])->name('dashboard');

    // ================================================
    // ---------------- Start Settings ----------------
    // ================================================

    Route::prefix('profile')->name('profile.')->group(function () {
        Route::get('edit', [ProfileController::class, 'edit'])->name('edit');
        Route::post('update', [ProfileController::class, 'update'])->name('update');
        Route::delete('destroy', [ProfileController::class, 'destroy'])->name('destroy');

        Route::prefix('password')->name('password.')->group(function () {
            Route::get('edit', [PasswordController::class, 'edit'])->name('edit');
            Route::put('update', [PasswordController::class, 'update'])->name('update');
        });
    });

    // ================================================
    // ---------------- End Settings ------------------
    // ================================================

    // ================================================
    // ---------------- Start Users ------------------
    // ================================================

    Route::prefix('users')->name('users.')->group(function () {
        Route::resource('/', UsersController::class)
            ->parameters(['' => 'user'])
            ->only(['index', 'create', 'store', 'edit', 'show', 'update', 'destroy'])
            ->names([
                'index' => 'index',
                'create' => 'create',
                'store' => 'store',
                'edit' => 'edit',
                'show' => 'show',
                'update' => 'update',
                'destroy' => 'destroy',
            ]);

        // Custom route for toggling user status
        Route::patch('/{user}/toggle-status', [UsersController::class, 'toggleStatus'])->name('toggle-status');
    });

    // ================================================
    // ---------------- Start Roles ------------------
    // ================================================

    Route::prefix('roles')->name('roles.')->group(function () {
        Route::resource('/', RolesController::class)
            ->parameters(['' => 'role'])
            ->only(['index', 'create', 'store', 'edit', 'show', 'update', 'destroy'])
            ->names([
                'index' => 'index',
                'create' => 'create',
                'store' => 'store',
                'edit' => 'edit',
                'show' => 'show',
                'update' => 'update',
                'destroy' => 'destroy',
            ]);
    });

    // ================================================
    // ---------------- End Roles --------------------
    // ================================================

    Route::prefix('permissions')->name('permissions.')->group(function () {
        Route::resource('/', PermissionsController::class)
            ->parameters(['' => 'permission'])
            ->only(['index', 'store', 'destroy'])
            ->names([
                'index' => 'index',
                'store' => 'store',
                'destroy' => 'destroy',
            ]);
    });

    // ================================================
    // ---------------- End Permissions --------------
    // ================================================

    // ================================================
    // ---------------- Start Settings ----------------
    // ================================================

    Route::prefix('settings')->name('settings.')->group(function () {
        Route::get('/', [SettingsController::class, 'index'])->name('index');
        Route::post('/update', [SettingsController::class, 'update'])->name('update');
    });

    // ================================================
    // ---------------- End Settings ------------------
    // ================================================
});
