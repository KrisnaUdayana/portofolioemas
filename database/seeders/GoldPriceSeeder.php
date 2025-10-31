<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\GoldPrice;
use Carbon\Carbon;

class GoldPriceSeeder extends Seeder
{
    public function run()
    {
        GoldPrice::create([
            'price_per_gram' => 975000,
            'source' => 'Logam Mulia',
            'date' => Carbon::today()
        ]);
    }
}
