<?php

use App\Http\Controllers\DashboardController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
Route::get('/gold-prices', function () {
    return view('gold-prices', ['title' => 'Harga Emas']);
})->name('gold.prices');

Route::get('/calculator', function () {
    return view('calculator', ['title' => 'Kalkulator Emas']);
})->name('calculator');
