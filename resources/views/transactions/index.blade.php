@extends('layouts.app')

@section('title', 'Riwayat Transaksi')

@section('content')
    <div class="mb-6">
        <a href="{{ route('transactions.create') }}"
            class="inline-flex items-center bg-gold-dark hover:bg-gold text-white font-bold py-3 px-6 rounded-lg transition duration-200">
            ➕ Tambah Transaksi Baru
        </a>
    </div>

    <div class="bg-white rounded-lg shadow">
        <div class="p-6 border-b">
            <div class="flex justify-between items-center">
                <div>
                    <h1 class="text-2xl font-bold text-gray-800">📋 Riwayat Transaksi Emas</h1>
                    <p class="text-gray-600">Catatan semua pembelian dan penjualan emas kamu</p>
                </div>
                <div class="text-right">
                    <p class="text-sm text-gray-600">Total Transaksi: <span
                            class="font-bold">{{ $transactions->count() }}</span></p>
                </div>
            </div>
        </div>

        @if ($transactions->count() > 0)
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Tanggal</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Jenis</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Berat</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Harga/Gram</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Total</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Keuntungan</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Catatan</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        @foreach ($transactions as $transaction)
                            <tr class="hover:bg-gray-50">
                                <td class="px-6 py-4 whitespace-nowrap">
                                    {{ $transaction->transaction_date->format('d M Y') }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    @if ($transaction->isBuy())
                                        <span
                                            class="inline-flex items-center px-2 py-1 bg-green-100 text-green-800 rounded-full text-sm">
                                            🔥 Beli
                                        </span>
                                    @else
                                        <span
                                            class="inline-flex items-center px-2 py-1 bg-red-100 text-red-800 rounded-full text-sm">
                                            💰 Jual
                                        </span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="font-semibold">{{ number_format($transaction->grams) }}</span> gram
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    Rp {{ number_format($transaction->price_per_gram, 0, ',', '.') }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap font-semibold">
                                    Rp {{ number_format($transaction->total_amount, 0, ',', '.') }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    @if ($transaction->isBuy())
                                        @php
                                            $profit = $transaction->profit ?? 0;
                                            $percentage = $transaction->profit_percentage ?? 0;
                                        @endphp
                                        <div class="text-right">
                                            <div
                                                class="font-semibold {{ $profit >= 0 ? 'text-green-600' : 'text-red-600' }}">
                                                {{ $profit >= 0 ? '+' : '' }}Rp {{ number_format($profit, 0, ',', '.') }}
                                            </div>
                                            <div class="text-xs {{ $percentage >= 0 ? 'text-green-500' : 'text-red-500' }}">
                                                {{ $percentage >= 0 ? '+' : '' }}{{ number_format($percentage) }}%
                                            </div>
                                        </div>
                                    @else
                                        <div class="text-right text-gray-400">
                                            <div>-</div>
                                            <div class="text-xs">-</div>
                                        </div>
                                    @endif
                                </td>
                                <td class="px-6 py-4 text-gray-600">
                                    {{ $transaction->notes ?? '-' }}
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <!-- Summary Card -->
            <div class="p-6 border-t bg-gray-50">
                <div class="grid grid-cols-1 md:grid-cols-4 gap-4 text-sm">
                    @php
                        $buyTransactions = $transactions->where('type', 'buy');
                        $totalInvestment = $buyTransactions->sum('total_amount');
                        $totalGrams = $buyTransactions->sum('grams');
                        $totalProfit = $buyTransactions->sum('profit');
                        $averageROI = $totalInvestment > 0 ? ($totalProfit / $totalInvestment) * 100 : 0;
                    @endphp
                    <div class="text-center p-3 bg-white rounded-lg border">
                        <div class="text-gray-600">Total Investasi</div>
                        <div class="font-bold text-lg">Rp {{ number_format($totalInvestment, 0, ',', '.') }}</div>
                    </div>
                    <div class="text-center p-3 bg-white rounded-lg border">
                        <div class="text-gray-600">Total Emas</div>
                        <div class="font-bold text-lg">{{ number_format($totalGrams) }} gram</div>
                    </div>
                    <div class="text-center p-3 bg-white rounded-lg border">
                        <div class="text-gray-600">Total Keuntungan</div>
                        <div class="font-bold text-lg {{ $totalProfit >= 0 ? 'text-green-600' : 'text-red-600' }}">
                            {{ $totalProfit >= 0 ? '+' : '' }}Rp {{ number_format($totalProfit, 0, ',', '.') }}
                        </div>
                    </div>
                    <div class="text-center p-3 bg-white rounded-lg border">
                        <div class="text-gray-600">ROI Rata-rata</div>
                        <div class="font-bold text-lg {{ $averageROI >= 0 ? 'text-green-600' : 'text-red-600' }}">
                            {{ $averageROI >= 0 ? '+' : '' }}{{ number_format($averageROI) }}%
                        </div>
                    </div>
                </div>
            </div>
        @else
            <div class="p-8 text-center">
                <div class="text-gray-400 text-6xl mb-4">📝</div>
                <h3 class="text-lg font-semibold text-gray-600 mb-2">Belum ada transaksi</h3>
                <p class="text-gray-500 mb-4">Mulai catat pembelian emas pertama kamu!</p>
                <a href="{{ route('transactions.create') }}"
                    class="inline-flex items-center bg-gold-dark hover:bg-gold text-white font-bold py-2 px-4 rounded-lg transition duration-200">
                    ➕ Tambah Transaksi Pertama
                </a>
            </div>
        @endif
    </div>
@endsection
