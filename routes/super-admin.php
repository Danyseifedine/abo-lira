<?php

use App\Http\Controllers\SuperAdmin\IndexController;
use App\Http\Controllers\SuperAdmin\Privileges\PermissionsController;
use App\Http\Controllers\SuperAdmin\Privileges\RolesController;
use App\Http\Controllers\SuperAdmin\Products\ProductCategoriesController;
use App\Http\Controllers\SuperAdmin\Products\ProductColorsController;
use App\Http\Controllers\SuperAdmin\Products\ProductQualitiesController;
use App\Http\Controllers\SuperAdmin\Products\ProductSizesController;
use App\Http\Controllers\SuperAdmin\Profile\PasswordController;
use App\Http\Controllers\SuperAdmin\Profile\ProfileController;
use App\Http\Controllers\SuperAdmin\UsersController;
use Illuminate\Support\Facades\Route;

Route::prefix('dashboard')->name('super-admin.')->group(function () {

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

    Route::prefix('users')->name('users.')->middleware('permission:access-super-admin-users')->group(function () {
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
    // ------------ Start Product Colors -------------
    // ================================================

    Route::prefix('product-colors')->name('product-colors.')->middleware('permission:access-super-admin-product-colors')->group(function () {
        Route::resource('/', ProductColorsController::class)
            ->parameters(['' => 'productColor'])
            ->only(['index', 'create', 'store', 'edit', 'update', 'destroy'])
            ->names([
                'index' => 'index',
                'create' => 'create',
                'store' => 'store',
                'edit' => 'edit',
                'update' => 'update',
                'destroy' => 'destroy',
            ]);

        // Custom route for toggling color status
        Route::patch('/{productColor}/toggle-status', [ProductColorsController::class, 'toggleStatus'])->name('toggle-status');
    });

    // ================================================
    // ------------ End Product Colors ---------------
    // ================================================

    // ================================================
    // ------------ Start Product Sizes --------------
    // ================================================

    Route::prefix('product-sizes')->name('product-sizes.')->middleware('permission:access-super-admin-product-sizes')->group(function () {
        Route::resource('/', ProductSizesController::class)
            ->parameters(['' => 'productSize'])
            ->only(['index', 'create', 'store', 'edit', 'update', 'destroy'])
            ->names([
                'index' => 'index',
                'create' => 'create',
                'store' => 'store',
                'edit' => 'edit',
                'update' => 'update',
                'destroy' => 'destroy',
            ]);

        // Custom route for toggling size status
        Route::patch('/{productSize}/toggle-status', [ProductSizesController::class, 'toggleStatus'])->name('toggle-status');
    });

    // ================================================
    // ------------ End Product Sizes ----------------
    // ================================================

    // ================================================
    // ------------ Start Product Qualities ----------
    // ================================================

    Route::prefix('product-qualities')->name('product-qualities.')->middleware('permission:access-super-admin-product-qualities')->group(function () {
        Route::resource('/', ProductQualitiesController::class)
            ->parameters(['' => 'productQuality'])
            ->only(['index', 'create', 'store', 'edit', 'update', 'destroy'])
            ->names([
                'index' => 'index',
                'create' => 'create',
                'store' => 'store',
                'edit' => 'edit',
                'update' => 'update',
                'destroy' => 'destroy',
            ]);

        // Custom route for toggling quality status
        Route::patch('/{productQuality}/toggle-status', [ProductQualitiesController::class, 'toggleStatus'])->name('toggle-status');
    });

    // ================================================
    // ------------ End Product Qualities ------------
    // ================================================

    // ================================================
    // ------------ Start Product Categories ---------
    // ================================================

    Route::prefix('product-categories')->name('product-categories.')->middleware('permission:access-super-admin-product-categories')->group(function () {
        Route::resource('/', ProductCategoriesController::class)
            ->parameters(['' => 'productCategory'])
            ->only(['index', 'create', 'store', 'edit', 'update', 'destroy'])
            ->names([
                'index' => 'index',
                'create' => 'create',
                'store' => 'store',
                'edit' => 'edit',
                'update' => 'update',
                'destroy' => 'destroy',
            ]);

        // Custom route for toggling category status
        Route::patch('/{productCategory}/toggle-status', [ProductCategoriesController::class, 'toggleStatus'])->name('toggle-status');
    });

    // ================================================
    // ------------ End Product Categories -----------
    // ================================================
});
