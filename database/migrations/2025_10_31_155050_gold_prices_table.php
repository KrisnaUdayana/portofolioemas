<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('gold_prices', function (Blueprint $table) {
            $table->id();
            $table->decimal('price_per_gram', 12, 2); // Harga per gram
            $table->string('source')->default('logam-mulia'); // Sumber harga
            $table->date('date'); // Tanggal update harga
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('gold_prices');
    }
};
