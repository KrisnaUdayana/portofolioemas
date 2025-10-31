<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\GoldPrice;
use App\Services\GoldPriceService;

class GoldPriceController extends Controller
{
    public function index()
    {
        // Hanya ambil harga terbaru saja
        $latestGoldPrice = GoldPrice::latest()->first();

        // Auto-fetch jika belum ada harga hari ini
        if (!$latestGoldPrice || $latestGoldPrice->date->notEqualTo(today())) {
            $goldService = new GoldPriceService();
            $latestGoldPrice = $goldService->fetchLatestPrice();
        }

        return view('gold-prices', [
            'title' => 'Harga Emas',
            'latestGoldPrice' => $latestGoldPrice
        ]);
    }

    public function updateManual(Request $request)
    {
        $request->validate([
            'manual_price' => 'required|numeric|min:1000'
        ]);

        $goldPrice = GoldPrice::updateOrCreate(
            ['date' => today()],
            [
                'price_per_gram' => $request->manual_price,
                'source' => 'manual'
            ]
        );

        return redirect()->route('gold.prices')
            ->with('success', 'Harga emas berhasil diupdate!');
    }
}
