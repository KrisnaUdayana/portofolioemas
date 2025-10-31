<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\GoldTransactionController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect()->route('dashboard');
});

Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

// Transactions Routes
Route::get('/transactions', [GoldTransactionController::class, 'index'])->name('transactions.index');
Route::get('/transactions/create', [GoldTransactionController::class, 'create'])->name('transactions.create');
Route::post('/transactions', [GoldTransactionController::class, 'store'])->name('transactions.store');

// Other routes...
Route::get('/gold-prices', function () {
    return view('gold-prices', ['title' => 'Harga Emas']);
})->name('gold.prices');

Route::get('/calculator', function () {
    return view('calculator', ['title' => 'Kalkulator Emas']);
})->name('calculator');
