<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Sarana;

class ResetMonthlyUsage extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:reset-monthly-usage';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        Sarana::query()->update(['bulanan_terpakai' => 0]);
        $this->info('Monthly usage counters reset successfully');
    }
}