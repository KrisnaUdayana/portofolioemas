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
                                <td class="px-6 py-4 text-gray-600">
                                    {{ $transaction->notes ?? '-' }}
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
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
