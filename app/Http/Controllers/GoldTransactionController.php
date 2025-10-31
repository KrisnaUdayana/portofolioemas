<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\GoldTransaction;

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

        return view('transactions.index', [
            'title' => 'Riwayat Transaksi Emas',
            'transactions' => $transactions
        ]);
    }
}
