<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Services\GoldPriceService;

class UpdateGoldPrice extends Command
{
    protected $signature = 'gold:update-price';
    protected $description = 'Update latest gold price from API';

    public function handle()
    {
        $this->info('Fetching latest gold price...');

        $goldService = new GoldPriceService();
        $goldPrice = $goldService->fetchLatestPrice();

        if ($goldPrice) {
            $this->info("✅ Gold price updated: Rp " . number_format($goldPrice->price_per_gram, 0, ',', '.') . "/gram");
        } else {
            $this->error('❌ Failed to fetch gold price');
        }
    }
}
