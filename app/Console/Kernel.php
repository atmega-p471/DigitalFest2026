<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    protected function schedule(Schedule $schedule): void
    {
        $schedule->command('app:simulate-daily-data')->dailyAt('03:00');
        $schedule->command('app:simulate-monthly-royalties')->monthlyOn(5, '04:00');
    }
}
