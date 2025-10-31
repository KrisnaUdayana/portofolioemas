<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GoldTransaction extends Model
{
    use HasFactory;

    protected $fillable = [
        'type',
        'grams',
        'price_per_gram',
        'total_amount',
        'transaction_date',
        'notes'
    ];

    protected $casts = [
        'grams' => 'decimal:3',
        'price_per_gram' => 'decimal:2',
        'total_amount' => 'decimal:2',
        'transaction_date' => 'date'
    ];

    // Helper methods
    public function isBuy()
    {
        return $this->type === 'buy';
    }

    public function isSell()
    {
        return $this->type === 'sell';
    }
}
