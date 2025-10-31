<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GoldPrice extends Model
{
    use HasFactory;

    protected $fillable = [
        'price_per_gram',
        'source',
        'date'
    ];

    protected $casts = [
        'price_per_gram' => 'decimal:2',
        'date' => 'date'
    ];

    // Scope untuk harga terbaru
    public function scopeLatestPrice($query)
    {
        return $query->orderBy('date', 'desc')->first();
    }
}
