<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schedule;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');

Schedule::command('app:simulate-daily-data')->dailyAt('03:00');
Schedule::command('app:simulate-monthly-royalties')->monthlyOn(5, '04:00');
