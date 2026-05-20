<?php

namespace App\Console\Commands;

use App\Services\DataSimulatorService;
use Carbon\Carbon;
use Illuminate\Console\Attributes\Description;
use Illuminate\Console\Attributes\Signature;
use Illuminate\Console\Command;

#[Signature('app:simulate-daily-data {--date=}')]
#[Description('Generate daily simulator streams and revenue entries')]
class SimulateDailyData extends Command
{
    public function __construct(private readonly DataSimulatorService $simulator)
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $date = $this->option('date');
        $generated = $this->simulator->generateDaily($date ? Carbon::parse($date) : null);
        $this->info("Daily data generated: {$generated} rows.");

        return self::SUCCESS;
    }
}
