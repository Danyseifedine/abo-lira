<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;





Schedule::command('temp:cleanup --hours=24')->daily();

Schedule::command('discounts:expire')->twiceDaily(1, 13);

Schedule::command('discounts:activate')->hourly();
