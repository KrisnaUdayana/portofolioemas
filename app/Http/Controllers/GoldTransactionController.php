<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\GoldTransaction;
use App\Models\GoldPrice;
use App\Services\GoldPriceService;


class GoldTransactionController extends Controller
{
    public function create()
    {
        return view('transactions.create', [
            'title' => 'Tambah Transaksi Emas'
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'type' => 'required|in:buy,sell',
            'grams' => 'required|numeric|min:0.001',
            'price_per_gram' => 'required|numeric|min:1',
            'transaction_date' => 'required|date',
            'notes' => 'nullable|string|max:500'
        ]);

        // Hitung total amount
        $validated['total_amount'] = $validated['grams'] * $validated['price_per_gram'];

        // Simpan transaksi
        GoldTransaction::create($validated);

        return redirect()->route('dashboard')
            ->with('success', 'Transaksi emas berhasil ditambahkan!');
    }

    public function index()
    {
        $transactions = GoldTransaction::orderBy('transaction_date', 'desc')->get();

        // SOLUSI: Always fetch fresh price from API
        $goldService = new GoldPriceService();
        $latestGoldPrice = $goldService->fetchLatestPrice();

        if ($latestGoldPrice) {
            $currentPricePerGram = $latestGoldPrice->price_per_gram;
            \Log::info("Fresh price from API: " . $currentPricePerGram);
        } else {
            // Fallback ke harga realistic
            $currentPricePerGram = 2107970;
            \Log::info("Using fallback price: " . $currentPricePerGram);
        }

        // Hitung profit
        $transactions->each(function ($transaction) use ($currentPricePerGram) {
            if ($transaction->isBuy()) {
                $currentValue = $transaction->grams * $currentPricePerGram;
                $transaction->profit = $currentValue - $transaction->total_amount;
                $transaction->profit_percentage = $transaction->total_amount > 0
                    ? ($transaction->profit / $transaction->total_amount) * 100
                    : 0;

                \Log::info("Transaction " . $transaction->id . " profit: " . $transaction->profit);
            }
        });

        return view('transactions.index', [
            'transactions' => $transactions,
            'currentPricePerGram' => $currentPricePerGram,
            'buyTransactions' => $transactions->where('type', 'buy')
        ]);
    }
}
