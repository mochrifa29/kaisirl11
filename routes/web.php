<?php

use App\Http\Controllers\HomeController;
use Illuminate\Support\Facades\Route;
use App\Livewire\Beranda;
use App\Livewire\User;
use App\Livewire\Transaksi;
use App\Livewire\Laporan;
use App\Livewire\Produk;
use Illuminate\Support\Facades\Auth;

Route::get('/', function () {
    return view('welcome');
});

Auth::routes(['register'=> false]);

Route::get('/home',Beranda::class)->middleware(['auth'])->name('home');
Route::get('/user',User::class)->middleware(['auth'])->name('user');
Route::get('/transaksi',Transaksi::class)->middleware(['auth'])->name('transaksi');
Route::get('/produk',Produk::class)->middleware(['auth'])->name('produk');
Route::get('/laporan',Laporan::class)->middleware(['auth'])->name('laporan');

Route::get('/cetak',[HomeController::class,'cetak']);


