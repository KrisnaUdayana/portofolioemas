<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Console\Scheduling\Schedule;
use App\Services\GoldPriceService;

class Kernel extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:kernel';

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
        //
    }

    protected function schedule(Schedule $schedule)
    {
        // Auto-update harga emas setiap hari jam 9 pagi
        $schedule->call(function () {
            $goldService = new GoldPriceService();
            $goldService->fetchLatestPrice();
        })->dailyAt('09:00');
    }
}
