<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use App\Models\GoldPrice;

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
                return $todayPrice; // Sudah ada, tidak perlu fetch lagi
            }

            // Fetch dari API real
            $realPrice = $this->fetchFromRealAPI();

            if ($realPrice) {
                return $this->saveGoldPrice($realPrice, 'metalpriceapi');
            }

            // Fallback ke mock data
            $mockPrice = $this->getRealisticMockPrice();
            return $this->saveGoldPrice($mockPrice, 'mock-fallback');
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

    private function getRealisticMockPrice()
    {
        // Harga realistis berdasarkan trend
        $basePrice = 975000;
        $randomChange = rand(-5000, 8000);
        return max($basePrice + $randomChange, 920000);
    }

    private function saveGoldPrice($price, $source)
    {
        return GoldPrice::create([
            'price_per_gram' => $price,
            'source' => $source,
            'date' => today()
        ]);
    }
}
