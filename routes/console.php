<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;



Schedule::command('telescope:prune --hours=48')->daily();

Schedule::call(function () {
    \Log::info('Test schedule running at ' . now());
})->everyFiveSeconds();

Schedule::command('temp:cleanup --hours=24')->daily();

// Warm portal cache every 5 minutes to ensure fast page loads
Schedule::command('portal:warm-cache')->everyFiveMinutes();
