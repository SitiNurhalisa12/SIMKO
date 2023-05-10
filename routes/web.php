<?php

use App\Http\Controllers\C_Kost;
use App\Http\Controllers\C_User;
use App\Http\Controllers\C_Kamar;
use App\Http\Controllers\C_Kosan;
use App\Http\Controllers\C_Login;
use App\Http\Controllers\C_Dashboard;
use App\Http\Controllers\C_Kategori;
use App\Http\Controllers\C_Pelaporan;
use App\Http\Controllers\C_Pengajuan;
use App\Http\Controllers\C_Penyewaan;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\C_Pembayaran;
use App\Http\Controllers\C_Registrasi;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', [C_Dashboard::class, 'home'])->name('home');
Route::get('/kategori', [C_Kategori::class, 'kategori']);
Route::get('/kost', [C_Kosan::class, 'index']);
Route::get('/kostan/{slug}', [C_Kost::class, 'kosan']);
Route::get('/tentang', [C_Dashboard::class, 'about']);
Route::get('/login', [C_Login::class, 'index'])->name('login')->middleware('guest');
Route::post('/login', [C_Login::class, 'authenticate'])->middleware('guest');
Route::post('/logout', [C_Login::class, 'logout'])->middleware('auth');
Route::get('/registrasi', [C_Registrasi::class, 'index'])->middleware('guest');
Route::post('/registrasi', [C_Registrasi::class, 'store'])->middleware('guest');
Route::get('/dashboard', [C_Dashboard::class, 'index'])->middleware('auth');
Route::get('/dashboard/profil', [C_User::class, 'profil'])->middleware('auth');
Route::resource('/dashboard/user', C_User::class)->middleware('auth');
Route::resource('/dashboard/kategori', C_Kategori::class)->middleware('auth');
Route::resource('/dashboard/kost', C_Kost::class)->middleware('auth');
Route::resource('/dashboard/pengajuan', C_Pengajuan::class)->middleware('auth');
Route::get('/dashboard/kamar/create/{slug}', [C_Kamar::class, 'create'])->middleware('auth');
Route::resource('/dashboard/kamar', C_Kamar::class)->middleware('auth');
Route::get('/dashboard/pelaporan/create/{slug}', [C_Pelaporan::class, 'create'])->middleware('auth');
Route::resource('/dashboard/pelaporan', C_Pelaporan::class)->middleware('auth');
Route::get('/dashboard/penyewaan/create/{slug}', [C_Penyewaan::class, 'create'])->middleware('auth');
Route::resource('/dashboard/penyewaan', C_Penyewaan::class)->middleware('auth');
Route::get('/dashboard/pembayaran/create/{slug}', [C_Pembayaran::class, 'create'])->middleware('auth');
Route::resource('/dashboard/pembayaran', C_Pembayaran::class)->middleware('auth');
