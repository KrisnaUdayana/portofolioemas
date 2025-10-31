<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Console\Scheduling\Schedule;

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
        // Update harga emas setiap hari jam 9 pagi
        $schedule->command('gold:update-price')->dailyAt('09:00');

        // Untuk testing, bisa jadwal lebih sering
        // $schedule->command('gold:update-price')->hourly();
    }
}
