<?php

namespace App\Providers;

use App\Models\Setting;
use Illuminate\Support\ServiceProvider;
use Inertia\Inertia;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        // Repository pattern removed - using Services directly
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Share settings with all Inertia views (excluding sensitive data)
        Inertia::share([
            'settings' => function () {
                return Setting::getAllGroupedForFrontend();
            },
        ]);
    }
}
