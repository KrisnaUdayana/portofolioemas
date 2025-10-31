<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use App\Models\GoldPrice;

class GoldPriceService
{
    public function fetchLatestPrice()
    {
        try {
            // Opsi 1: Mock API (sementara untuk development)
            $mockPrice = $this->getMockGoldPrice();

            // Simpan ke database
            $goldPrice = GoldPrice::create([
                'price_per_gram' => $mockPrice,
                'source' => 'logam-mulia',
                'date' => now()->toDateString()
            ]);

            return $goldPrice;
        } catch (\Exception $e) {
            Log::error('Error fetching gold price: ' . $e->getMessage());
            return null;
        }
    }

    private function getMockGoldPrice()
    {
        // Simulasi fluktuasi harga emas real
        $basePrice = 975000; // Harga dasar
        $randomChange = rand(-5000, 10000); // Perubahan acak -5k sampai +10k
        return $basePrice + $randomChange;
    }

    // Method untuk API real (nanti diimplementasi)
    private function fetchFromRealAPI()
    {
        // Contoh dengan API gratis (butuh registrasi dulu)
        /*
        $response = Http::get('https://api.metalpriceapi.com/v1/latest', [
            'api_key' => 'your_api_key',
            'base' => 'XAU',
            'currencies' => 'IDR'
        ]);

        if ($response->successful()) {
            $data = $response->json();
            // Convert dari USD/Ounce ke IDR/gram
            return $this->convertToIDRPerGram($data['rates']['IDR']);
        }
        */

        return null;
    }

    private function convertToIDRPerGram($usdPerOunce)
    {
        // 1 ounce = 31.1035 gram
        // Konversi USD to IDR (butuh API terpisah)
        $usdToIdr = 15000; // Rate dummy
        return ($usdPerOunce * $usdToIdr) / 31.1035;
    }
}
