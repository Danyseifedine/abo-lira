<?php

use App\Http\Controllers\BaseController;
use App\Navigation\SuperAdminPath;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;

if (config('app.features.multi_lang')) {
    Route::group(
        [
            'prefix' => LaravelLocalization::setLocale(),
            'middleware' => ['localeSessionRedirect', 'localizationRedirect', 'localeViewPath'],
        ],
        function () {
            registerWebRoutes();
        }
    );
} else {
    registerWebRoutes();
}

// i need better name then defineRoutes
function registerWebRoutes()
{
    Route::get('/', function () {
        return view('landing');
    })->name('home');

    Route::get('/about', function () {
        return view('about');
    })->name('about');

    Route::get('/contact', function () {
        return view('contact');
    })->name('contact');

    Route::get('/shop', function () {
        return view('shop');
    })->name('shop');

    Route::get('/cart', function () {
        return view('cart');
    })->name('cart');

    Route::get('/detail', function () {
        return view('detail');
    })->name('detail');

    Route::middleware([
        'auth',
        'verified',
        'role:owner|super-admin',
    ])->group(function () {
        require __DIR__ . '/super-admin.php';
    });

    require __DIR__ . '/auth.php';

    Route::get('/documentation', function () {
        return Inertia::render(SuperAdminPath::view('documentation/Index'));
    })->name('super-admin.documentation');



    // =========================================================
    // ---------------- Start File Uploads (GLOBAL) ------------
    // =========================================================

    Route::prefix('uploads')->group(function () {
        Route::post('/temp', [BaseController::class, 'uploadTemp'])->name('uploads.temp.store');
        Route::delete('/temp', [BaseController::class, 'deleteTemp'])->name('uploads.temp.destroy');
        Route::post('/temp/cleanup', [BaseController::class, 'cleanupTemp'])->name('uploads.temp.cleanup');
    });

    // =========================================================
    // ---------------- End File Uploads (GLOBAL) --------------
    // =========================================================
}
