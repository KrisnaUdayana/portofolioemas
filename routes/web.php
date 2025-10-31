<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\GoldTransactionController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\GoldPriceController;
use App\Http\Controllers\GoldExportController;

Route::get('/', function () {
    return redirect()->route('dashboard');
});

Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

// Transactions Routes
Route::get('/transactions', [GoldTransactionController::class, 'index'])->name('transactions.index');
Route::get('/transactions/create', [GoldTransactionController::class, 'create'])->name('transactions.create');
Route::post('/transactions', [GoldTransactionController::class, 'store'])->name('transactions.store');

// Other routes...
Route::get('/gold-prices', [GoldPriceController::class, 'index'])->name('gold.prices');
Route::post('/gold-prices/update', [GoldPriceController::class, 'updateManual'])->name('gold.update-manual');
Route::get('/gold-prices/export', [GoldExportController::class, 'exportPDF'])->name('gold.export.pdf');

Route::get('/calculator', function () {
    return view('calculator', ['title' => 'Kalkulator Emas']);
})->name('calculator');
