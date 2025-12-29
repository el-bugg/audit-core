<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DeteksiController; // Panggil Controller Anda

// Halaman Utama
Route::get('/', [DeteksiController::class, 'index']);

// Jalur untuk memproses gambar (POST)
Route::post('/proses-analisa', [DeteksiController::class, 'prosesAnalisa'])->name('proses.analisa');