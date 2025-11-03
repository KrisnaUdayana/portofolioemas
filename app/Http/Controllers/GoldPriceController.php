<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\GoldPrice;
use App\Services\GoldPriceService;

class GoldPriceController extends Controller
{
    public function index(Request $request)
    {
        $goldService = new GoldPriceService();

        // Auto-fetch harga hari ini jika belum ada
        $latestGoldPrice = $goldService->fetchLatestPrice();

        // Ambil riwayat harga 30 hari terakhir
        $priceHistory = $goldService->getPriceHistory(30);

        return view('gold-prices', [
            'title' => 'Harga Emas Terkini & Riwayat',
            'latestGoldPrice' => $latestGoldPrice,
            'priceHistory' => $priceHistory
        ]);
    }

    public function updateManual(Request $request)
    {
        $request->validate([
            'manual_price' => 'required|numeric|min:1000'
        ]);

        $goldPrice = GoldPrice::updateOrCreate(
            ['date' => today()], // SELALU untuk hari ini
            [
                'price_per_gram' => $request->manual_price,
                'source' => 'manual'
            ]
        );

        return redirect()->route('gold.prices')
            ->with('success', 'Harga emas berhasil diupdate!');
    }
}
