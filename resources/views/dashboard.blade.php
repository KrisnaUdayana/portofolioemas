@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
<div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
    <!-- Card: Total Investasi -->
    <div class="bg-white rounded-lg shadow p-6 border-l-4 border-gold">
        <h3 class="text-lg font-semibold text-gray-700">Total Investasi</h3>
        <p class="text-2xl font-bold text-gold-dark mt-2">Rp 0</p>
        <p class="text-sm text-gray-500">Belum ada transaksi</p>
    </div>

    <!-- Card: Jumlah Emas -->
    <div class="bg-white rounded-lg shadow p-6 border-l-4 border-blue-500">
        <h3 class="text-lg font-semibold text-gray-700">Total Emas</h3>
        <p class="text-2xl font-bold text-blue-600 mt-2">0 gram</p>
        <p class="text-sm text-gray-500">Dalam portfolio</p>
    </div>

    <!-- Card: Profit/Loss -->
    <div class="bg-white rounded-lg shadow p-6 border-l-4 border-green-500">
        <h3 class="text-lg font-semibold text-gray-700">Estimasi Profit</h3>
        <p class="text-2xl font-bold text-green-600 mt-2">Rp 0</p>
        <p class="text-sm text-gray-500">Berdasar harga saat ini</p>
    </div>
</div>

<!-- Quick Actions -->
<div class="bg-white rounded-lg shadow p-6">
    <h2 class="text-xl font-bold text-gray-800 mb-4">Quick Actions</h2>
    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
        <a href="{{ route('calculator') }}"
           class="bg-gold hover:bg-gold-dark text-white py-3 px-6 rounded-lg text-center font-semibold transition duration-200">
            💰 Kalkulator Investasi
        </a>
        <a href="{{ route('gold.prices') }}"
           class="bg-blue-500 hover:bg-blue-600 text-white py-3 px-6 rounded-lg text-center font-semibold transition duration-200">
            📈 Lihat Harga Emas
        </a>
    </div>
</div>
@endsection
