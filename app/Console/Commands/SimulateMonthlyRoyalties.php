<?php

namespace App\Console\Commands;

use App\Services\DataSimulatorService;
use Carbon\Carbon;
use Illuminate\Console\Attributes\Description;
use Illuminate\Console\Attributes\Signature;
use Illuminate\Console\Command;

#[Signature('app:simulate-monthly-royalties {--month=}')]
#[Description('Generate monthly payout records from simulator data')]
class SimulateMonthlyRoyalties extends Command
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
        $month = $this->option('month');
        $monthDate = $month ? Carbon::parse($month) : now()->subMonth();
        $generated = $this->simulator->generateMonthly($monthDate);
        $this->info("Monthly payouts generated: {$generated} rows.");

        return self::SUCCESS;
    }
}
