<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use App\Models\GoldPrice;
use Carbon\Carbon;

class GoldPriceService
{
    private $apiKey;
    private $baseUrl = 'https://api.metalpriceapi.com/v1/';

    public function __construct()
    {
        $this->apiKey = env('METALPRICE_API_KEY');
    }

    public function fetchLatestPrice()
    {
        try {
            // Cek apakah sudah ada harga untuk hari ini
            $todayPrice = GoldPrice::whereDate('date', today())->first();

            if ($todayPrice) {
                Log::info('Harga hari ini sudah ada: Rp ' . number_format($todayPrice->price_per_gram, 0));
                return $todayPrice;
            }

            Log::info('Fetching harga baru dari API...');

            // Fetch dari API real saja - TIDAK ADA FALLBACK MOCK
            $realPrice = $this->fetchFromRealAPI();

            if ($realPrice) {
                $savedPrice = $this->saveGoldPrice($realPrice, 'metalpriceapi');
                Log::info('Harga API real disimpan: Rp ' . number_format($savedPrice->price_per_gram, 0));
                return $savedPrice;
            }

            // ❌ TIDAK ADA FALLBACK KE MOCK DATA
            Log::warning('API gagal, return null');
            return null;
        } catch (\Exception $e) {
            Log::error('Error fetching gold price: ' . $e->getMessage());
            return null;
        }
    }

    private function fetchFromRealAPI()
    {
        if (!$this->apiKey || $this->apiKey === 'your_actual_api_key_here') {
            Log::warning('MetalPrice API key not set or still default');
            return null;
        }

        $response = Http::timeout(10)->get($this->baseUrl . 'latest', [
            'api_key' => $this->apiKey,
            'base' => 'XAU',
            'currencies' => 'IDR'
        ]);

        if ($response->successful()) {
            $data = $response->json();

            // Convert dari USD/Ounce ke IDR/gram
            $idrPerOunce = $data['rates']['IDR'];
            $idrPerGram = $idrPerOunce / 31.1035;

            Log::info('Gold price fetched from API: Rp ' . number_format($idrPerGram, 0));
            return $idrPerGram;
        } else {
            Log::error('API request failed: ' . $response->body());
            return null;
        }
    }

    private function saveGoldPrice($price, $source)
    {
        // Hanya simpan jika dari API real atau manual
        return GoldPrice::create([
            'price_per_gram' => $price,
            'source' => $source,
            'date' => today()
        ]);
    }

    // Method untuk lihat riwayat harga REAL saja
    public function getPriceHistory($days = 30)
    {
        return GoldPrice::whereDate('date', '>=', now()->subDays($days))
            ->where('source', '!=', 'historical-mock') // ❌ EXCLUDE MOCK DATA
            ->where('source', '!=', 'mock-fallback')   // ❌ EXCLUDE MOCK DATA
            ->orderBy('date', 'desc')
            ->get();
    }
}
