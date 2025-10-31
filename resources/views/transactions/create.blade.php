@extends('layouts.app')

@section('title', 'Tambah Transaksi Emas')

@section('content')
    <div class="max-w-2xl mx-auto">
        <div class="bg-white rounded-lg shadow p-6">
            <h1 class="text-2xl font-bold text-gray-800 mb-6">➕ Tambah Transaksi Emas</h1>

            <form action="{{ route('transactions.store') }}" method="POST">
                @csrf

                <!-- Type Transaksi -->
                <div class="mb-4">
                    <label class="block text-gray-700 text-sm font-bold mb-2">Jenis Transaksi</label>
                    <div class="flex space-x-4">
                        <label class="flex items-center">
                            <input type="radio" name="type" value="buy" checked class="form-radio text-gold-dark">
                            <span class="ml-2">Beli Emas</span>
                        </label>
                        <label class="flex items-center">
                            <input type="radio" name="type" value="sell" class="form-radio text-red-500">
                            <span class="ml-2">Jual Emas</span>
                        </label>
                    </div>
                </div>

                <!-- Grams -->
                <div class="mb-4">
                    <label for="grams" class="block text-gray-700 text-sm font-bold mb-2">
                        Berat Emas (gram)
                    </label>
                    <input type="number" step="0.001" name="grams" id="grams"
                        class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-gold-dark"
                        placeholder="Contoh: 5.250" required>
                </div>

                <!-- Price per Gram -->
                <div class="mb-4">
                    <label for="price_per_gram" class="block text-gray-700 text-sm font-bold mb-2">
                        Harga per Gram (Rp)
                    </label>
                    <input type="number" name="price_per_gram" id="price_per_gram"
                        class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-gold-dark"
                        placeholder="Contoh: 975000" required>
                </div>

                <!-- Transaction Date -->
                <div class="mb-4">
                    <label for="transaction_date" class="block text-gray-700 text-sm font-bold mb-2">
                        Tanggal Transaksi
                    </label>
                    <input type="date" name="transaction_date" id="transaction_date"
                        class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-gold-dark"
                        value="{{ date('Y-m-d') }}" required>
                </div>

                <!-- Notes -->
                <div class="mb-6">
                    <label for="notes" class="block text-gray-700 text-sm font-bold mb-2">
                        Catatan (Opsional)
                    </label>
                    <textarea name="notes" id="notes" rows="3"
                        class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-gold-dark"
                        placeholder="Contoh: Beli di Antam Cabang BSD, Emas 24 karat..."></textarea>
                </div>

                <!-- Preview & Submit -->
                <div class="bg-gray-50 p-4 rounded-lg mb-6">
                    <h3 class="font-semibold text-gray-700 mb-2">Preview:</h3>
                    <p id="preview" class="text-gray-600">Isi form untuk melihat preview</p>
                </div>

                <div class="flex space-x-4">
                    <button type="submit"
                        class="bg-gold-dark hover:bg-gold text-white font-bold py-3 px-6 rounded-lg transition duration-200">
                        💰 Simpan Transaksi
                    </button>
                    <a href="{{ route('dashboard') }}"
                        class="bg-gray-500 hover:bg-gray-600 text-white font-bold py-3 px-6 rounded-lg transition duration-200">
                        Kembali
                    </a>
                </div>
            </form>
        </div>
    </div>

    <script>
        // Real-time preview
        document.addEventListener('DOMContentLoaded', function() {
            const gramsInput = document.getElementById('grams');
            const priceInput = document.getElementById('price_per_gram');
            const typeInputs = document.querySelectorAll('input[name="type"]');
            const previewElement = document.getElementById('preview');

            function updatePreview() {
                const grams = gramsInput.value || 0;
                const price = priceInput.value || 0;
                const type = document.querySelector('input[name="type"]:checked').value;
                const total = grams * price;

                const typeText = type === 'buy' ? 'Pembelian' : 'Penjualan';
                previewElement.textContent =
                    `${typeText} emas ${grams} gram @ Rp ${Number(price).toLocaleString('id-ID')} = Rp ${Number(total).toLocaleString('id-ID')}`;
            }

            gramsInput.addEventListener('input', updatePreview);
            priceInput.addEventListener('input', updatePreview);
            typeInputs.forEach(input => input.addEventListener('change', updatePreview));
        });
    </script>
@endsection
