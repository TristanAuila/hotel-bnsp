<?php

use App\Http\Controllers\BookingController;
use App\Http\Controllers\PageController;
use Illuminate\Support\Facades\Route;

Route::get('/', [PageController::class, 'home'])->name('home');
Route::get('/produk', [PageController::class, 'produk'])->name('produk');
Route::get('/harga', [PageController::class, 'harga'])->name('harga');
Route::get('/tentang', [PageController::class, 'tentang'])->name('tentang');
Route::get('/galeri', [PageController::class, 'galeri'])->name('galeri');

Route::get('/pesan', [BookingController::class, 'create'])->name('pesan.create');
Route::post('/pesan', [BookingController::class, 'store'])->name('pesan.store');
Route::get('/pesan/sukses/{kodeBooking}', [BookingController::class, 'success'])->name('booking.success');
