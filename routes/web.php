<?php

use App\Http\Controllers\BaseController;
use App\Navigation\SuperAdminPath;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;
use App\Http\Controllers\Portal\HomeController;

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
    Route::controller(HomeController::class)->group(function () {
        Route::get('/', 'home')->name('home');
        Route::get('/about', 'about')->name('about');
        Route::get('/contact', 'contact')->name('contact');
        Route::get('/shop', 'shop')->name('shop');
        Route::get('/cart', 'cart')->name('cart');
        Route::get('/detail', 'detail')->name('detail');
        Route::get('/checkout', 'checkout')->name('checkout');
    });


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
