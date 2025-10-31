<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('gold_transactions', function (Blueprint $table) {
            $table->id();
            $table->string('type'); // 'buy' atau 'sell'
            $table->decimal('grams', 8, 3); // Berat emas dalam gram
            $table->decimal('price_per_gram', 12, 2); // Harga saat transaksi
            $table->decimal('total_amount', 12, 2); // Total nilai transaksi
            $table->date('transaction_date');
            $table->text('notes')->nullable(); // Catatan tambahan
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('gold_transactions');
    }
};
