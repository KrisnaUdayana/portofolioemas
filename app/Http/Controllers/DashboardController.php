<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\GoldTransaction;
use App\Models\GoldPrice;
use App\Services\GoldPriceService;

class DashboardController extends Controller
{
    public function index()
    {
        // Cek apakah ada harga hari ini, jika tidak fetch yang baru
        $latestGoldPrice = GoldPrice::whereDate('date', today())->first();

        if (!$latestGoldPrice) {
            $goldService = new GoldPriceService();
            $latestGoldPrice = $goldService->fetchLatestPrice();
        }

        // Fallback ke harga terakhir jika masih null
        if (!$latestGoldPrice) {
            $latestGoldPrice = GoldPrice::latest()->first();
        }

        $transactions = GoldTransaction::all();

        // Hitung total investasi
        $totalInvestment = $transactions->where('type', 'buy')->sum('total_amount');
        $totalGrams = $transactions->where('type', 'buy')->sum('grams') -
            $transactions->where('type', 'sell')->sum('grams');

        // Estimasi profit
        $currentValue = $latestGoldPrice ? $totalGrams * $latestGoldPrice->price_per_gram : 0;
        $estimatedProfit = $currentValue - $totalInvestment;

        return view('dashboard', [
            'title' => 'Dashboard Portfolio Emas',
            'totalInvestment' => $totalInvestment,
            'totalGrams' => $totalGrams,
            'estimatedProfit' => $estimatedProfit,
            'latestGoldPrice' => $latestGoldPrice,
            'transactions' => $transactions
        ]);
    }
}
