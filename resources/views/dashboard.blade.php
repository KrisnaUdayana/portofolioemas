@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
        <!-- Card: Total Investasi -->
        <div class="bg-white rounded-lg shadow p-6 border-l-4 border-gold">
            <h3 class="text-lg font-semibold text-gray-700">Total Investasi</h3>
            <p class="text-2xl font-bold text-gold-dark mt-2">Rp {{ number_format($totalInvestment, 0, ',', '.') }}</p>
            <p class="text-sm text-gray-500">{{ $transactions->count() }} transaksi</p>
        </div>

        <!-- Card: Jumlah Emas -->
        <div class="bg-white rounded-lg shadow p-6 border-l-4 border-blue-500">
            <h3 class="text-lg font-semibold text-gray-700">Total Emas</h3>
            <p class="text-2xl font-bold text-blue-600 mt-2">{{ number_format($totalGrams) }} gram</p>
            <p class="text-sm text-gray-500">
                @if ($latestGoldPrice)
                    Rp {{ number_format($latestGoldPrice->price_per_gram, 0, ',', '.') }}/gram
                @else
                    Harga belum tersedia
                @endif
            </p>
        </div>

        <!-- Card: Profit/Loss -->
        <div
            class="bg-white rounded-lg shadow p-6 border-l-4 {{ $estimatedProfit >= 0 ? 'border-green-500' : 'border-red-500' }}">
            <h3 class="text-lg font-semibold text-gray-700">Estimasi Profit</h3>
            <p class="text-2xl font-bold {{ $estimatedProfit >= 0 ? 'text-green-600' : 'text-red-600' }} mt-2">
                Rp {{ number_format($estimatedProfit, 0, ',', '.') }}
            </p>
            <p class="text-sm text-gray-500">Berdasar harga saat ini</p>
        </div>
    </div>

    <!-- Harga Emas Terkini -->
    @if ($latestGoldPrice)
        <div class="bg-white rounded-lg shadow p-6 mb-6">
            <h2 class="text-xl font-bold text-gray-800 mb-4">💰 Harga Emas Terkini</h2>
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-2xl font-bold text-gold-dark">Rp
                        {{ number_format($latestGoldPrice->price_per_gram, 0, ',', '.') }}</p>
                    <p class="text-gray-600">per gram • {{ $latestGoldPrice->source }}</p>
                </div>
                <span class="bg-green-100 text-green-800 px-3 py-1 rounded-full text-sm">
                    {{ $latestGoldPrice->date->format('d M Y') }}
                </span>
            </div>
        </div>
    @endif

    <!-- Quick Actions -->
    <div class="bg-white rounded-lg shadow p-6">
        <h2 class="text-xl font-bold text-gray-800 mb-4">Quick Actions</h2>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
            <a href="{{ route('calculator') }}"
                class="bg-gold hover:bg-gold-dark text-white py-3 px-6 rounded-lg text-center font-semibold transition duration-200">
                💰 Kalkulator Investasi
            </a>
            <a href="{{ route('gold.prices') }}"
                class="bg-blue-500 hover:bg-blue-600 text-white py-3 px-6 rounded-lg text-center font-semibold transition duration-200">
                📈 Lihat Harga Emas
            </a>
            <a href="{{ route('transactions.create') }}"
                class="bg-green-500 hover:bg-green-600 text-white py-3 px-6 rounded-lg text-center font-semibold transition duration-200">
                ➕ Tambah Transaksi
            </a>
        </div>
    </div>
@endsection
