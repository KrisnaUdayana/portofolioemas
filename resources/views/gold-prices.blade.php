@extends('layouts.app')

@section('title', 'Harga Emas Terkini')

@section('content')
    <div class="min-h-screen bg-gray-50 py-8">
        <div class="max-w-6xl mx-auto px-4">

            <!-- Kartu Utama Harga Emas -->
            <div class="bg-white rounded-2xl shadow-lg border border-gray-200 overflow-hidden mb-8">
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

                    <!-- Manual Update Form -->
                    <div class="mt-8 pt-8 border-t border-gray-200">
                        <div class="max-w-md mx-auto">
                            <h4 class="text-lg font-semibold text-gray-800 mb-4 text-center">✏️ Update Harga Manual</h4>
                            <form action="{{ route('gold.update-manual') }}" method="POST" class="space-y-4">
                                @csrf
                                <div class="flex space-x-3">
                                    <input type="number" name="manual_price" placeholder="Contoh: 975000"
                                        class="flex-1 px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-yellow-500 focus:border-yellow-500 text-lg font-medium"
                                        required>
                                    <button type="submit"
                                        class="bg-gradient-to-r from-green-500 to-green-600 hover:from-green-600 hover:to-green-700 text-white font-bold py-3 px-6 rounded-xl transition-all duration-300 shadow-lg hover:shadow-xl">
                                        💾 Simpan
                                    </button>
                                </div>
                                <p class="text-sm text-gray-500 text-center">
                                    Harga akan disimpan sebagai riwayat untuk hari ini
                                </p>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Riwayat Harga -->
            <div class="bg-white rounded-2xl shadow-lg border border-gray-200 overflow-hidden mt-8">
                <div class="bg-gradient-to-r from-blue-500 to-blue-600 px-8 py-6">
                    <div class="flex items-center justify-between">
                        <div class="flex items-center space-x-4">
                            <div class="bg-white bg-opacity-20 p-3 rounded-xl">
                                <span class="text-2xl text-white">📈</span>
                            </div>
                            <div>
                                <h2 class="text-2xl font-bold text-white">Riwayat Harga Real</h2>
                                <p class="text-blue-100 text-sm">Data harga dari API dan input manual saja</p>
                            </div>
                        </div>
                        <div class="text-blue-100 text-sm">
                            {{ $priceHistory->count() }} data real
                        </div>
                    </div>
                </div>

                <div class="p-6">
                    @if ($priceHistory->count() > 0)
                        <div class="overflow-x-auto">
                            <table class="w-full">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Tanggal
                                        </th>
                                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">
                                            Harga/Gram</th>
                                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Sumber
                                        </th>
                                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Status
                                        </th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-gray-200">
                                    @foreach ($priceHistory as $history)
                                        <tr class="hover:bg-gray-50">
                                            <td class="px-4 py-3 whitespace-nowrap">
                                                <div class="flex items-center space-x-2">
                                                    @if ($history->date->isToday())
                                                        <span
                                                            class="bg-green-100 text-green-800 px-2 py-1 rounded-full text-xs font-medium">HARI
                                                            INI</span>
                                                    @endif
                                                    <span
                                                        class="text-gray-700 font-medium">{{ $history->date->format('d M Y') }}</span>
                                                </div>
                                            </td>
                                            <td class="px-4 py-3 whitespace-nowrap">
                                                <span class="font-bold text-gray-800">Rp
                                                    {{ number_format($history->price_per_gram, 0, ',', '.') }}</span>
                                            </td>
                                            <td class="px-4 py-3 whitespace-nowrap">
                                                @if ($history->source === 'metalpriceapi')
                                                    <span
                                                        class="inline-flex items-center px-2 py-1 bg-blue-100 text-blue-800 rounded-full text-xs font-medium">
                                                        🌐 API Real
                                                    </span>
                                                @elseif($history->source === 'manual')
                                                    <span
                                                        class="inline-flex items-center px-2 py-1 bg-green-100 text-green-800 rounded-full text-xs font-medium">
                                                        ✏️ Manual
                                                    </span>
                                                @else
                                                    <span
                                                        class="inline-flex items-center px-2 py-1 bg-gray-100 text-gray-800 rounded-full text-xs font-medium">
                                                        {{ $history->source }}
                                                    </span>
                                                @endif
                                            </td>
                                            <td class="px-4 py-3 whitespace-nowrap">
                                                @if ($history->date->isToday())
                                                    <span
                                                        class="bg-yellow-100 text-yellow-800 px-2 py-1 rounded-full text-xs font-medium">Aktif</span>
                                                @else
                                                    <span
                                                        class="bg-gray-100 text-gray-800 px-2 py-1 rounded-full text-xs font-medium">Riwayat</span>
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                        <!-- Info Data Real -->
                        <div class="mt-4 p-4 bg-green-50 border border-green-200 rounded-lg">
                            <div class="flex items-center space-x-2 text-green-700">
                                <span>✅</span>
                                <p class="text-sm">Menampilkan <strong>{{ $priceHistory->count() }} data real</strong> dari
                                    API dan input manual</p>
                            </div>
                        </div>
                    @else
                        <div class="text-center py-12">
                            <div class="text-6xl mb-4">📊</div>
                            <h3 class="text-xl font-bold text-gray-600 mb-2">Belum Ada Data Real</h3>
                            <p class="text-gray-500 mb-6">Update harga emas melalui API atau input manual untuk mulai
                                membangun riwayat</p>

                            <div class="space-y-3 max-w-md mx-auto">
                                <form action="{{ route('gold.update-manual') }}" method="POST" class="flex space-x-2">
                                    @csrf
                                    <input type="number" name="manual_price" placeholder="Input harga manual"
                                        class="flex-1 px-3 py-2 border border-gray-300 rounded-lg" required>
                                    <button type="submit"
                                        class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-lg font-medium">
                                        💾 Simpan
                                    </button>
                                </form>
                                <p class="text-xs text-gray-400">Atau klik "Refresh" untuk fetch dari API</p>
                            </div>
                        </div>
                    @endif
                </div>
            </div>

        </div>
    </div>
@endsection
