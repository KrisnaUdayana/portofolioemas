@extends('layouts.app')

@section('title', 'Harga Emas Terkini')

@section('content')
    <div class="min-h-screen">
        <div class="max-w-4xl mx-auto px-4">
            <!-- Kartu Utama Harga Emas -->
            <div class="bg-white rounded-2xl shadow-lg border overflow-hidden">
                <!-- Header Card dengan Gradient -->
                <div class="bg-gradient-to-r from-yellow-400 to-yellow-500 px-8 py-6">
                    <div class="flex items-center justify-between">
                        <div class="flex items-center space-x-4">
                            <div class="bg-white bg-opacity-20 p-3 rounded-xl">
                                <span class="text-2xl text-white">💰</span>
                            </div>
                            <div>
                                <h1 class="text-2xl font-bold text-white">Harga Emas Terkini</h1>
                                <p class="text-yellow-100 text-sm">Informasi harga emas per gram</p>
                            </div>
                        </div>
                        <form action="{{ route('gold.update-manual') }}" method="POST">
                            @csrf
                            <button type="submit"
                                class="bg-white bg-opacity-20 hover:bg-opacity-30 text-white px-6 py-3 rounded-xl font-semibold transition-all duration-300 backdrop-blur-sm border border-white border-opacity-30">
                                🔄 Refresh
                            </button>
                        </form>
                    </div>
                </div>

                <!-- Konten Harga -->
                <div class="p-8">
                    @if ($latestGoldPrice)
                        <div class="text-center space-y-6">
                            <!-- Harga Utama -->
                            <div class="space-y-2">
                                <h2 class="text-7xl font-black text-gray-800 tracking-tight">
                                    Rp {{ number_format($latestGoldPrice->price_per_gram, 0, ',', '.') }}
                                </h2>
                                <p class="text-gray-500 text-lg font-medium">per gram</p>
                            </div>

                            <!-- Informasi Tambahan -->
                            <div class="flex justify-center space-x-4">
                                <div class="bg-yellow-50 border border-yellow-200 px-4 py-2 rounded-full">
                                    <span class="text-yellow-700 font-semibold text-sm">
                                        📅 {{ $latestGoldPrice->date->format('d M Y') }}
                                    </span>
                                </div>
                                <div class="bg-blue-50 border border-blue-200 px-4 py-2 rounded-full">
                                    <span class="text-blue-700 font-semibold text-sm">
                                        🔧 {{ $latestGoldPrice->source }}
                                    </span>
                                </div>
                            </div>
                        </div>
                    @else
                        <!-- State Kosong -->
                        <div class="text-center py-12 space-y-6">
                            <div class="text-8xl mb-4">😴</div>
                            <div class="space-y-2">
                                <h3 class="text-2xl font-bold text-gray-600">Harga Belum Tersedia</h3>
                                <p class="text-gray-500">Update harga emas untuk melihat informasi terkini</p>
                            </div>
                            <form action="{{ route('gold.update-manual') }}" method="POST">
                                @csrf
                                <button type="submit"
                                    class="bg-gradient-to-r from-yellow-500 to-yellow-600 hover:from-yellow-600 hover:to-yellow-700 text-white px-8 py-4 rounded-xl font-bold text-lg transition-all duration-300 shadow-lg hover:shadow-xl">
                                    🔄 Update Sekarang
                                </button>
                            </form>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection
