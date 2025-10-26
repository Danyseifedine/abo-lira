<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;



Schedule::command('telescope:prune --hours=48')->daily();

Schedule::call(function () {
    \Log::info('Test schedule running at ' . now());
})->everyFiveSeconds();


