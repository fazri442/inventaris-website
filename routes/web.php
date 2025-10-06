<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DataPusatController;
use App\Http\Controllers\PeminjamController;
use App\Http\Controllers\BarangMasukController;
use App\Http\Controllers\BarangkeluarController;
use App\Http\Controllers\PengembalianController;
use App\Http\Controllers\PenggunaController;
use App\Http\Middleware\isAdmin;



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

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();
Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::prefix('admin')->middleware(['auth',isAdmin::class])->group(function () {
Route::resource('datapusat', DataPusatController::class);
// Tambahan untuk export PDF
Route::get('barang-export', [DataPusatController::class, 'export'])->name('barang.export');

Route::resource('peminjam', PeminjamController::class);
Route::get('peminjam-export', [PeminjamController::class, 'export'])->name('peminjam.export');

Route::resource('barangmasuk', BarangMasukController::class);
Route::get('barangmasuk-export', [BarangMasukController::class, 'export'])->name('barangmasuk.export');

route::resource('barangkeluar', BarangkeluarController::class);
Route::get('barangkeluar-export', [BarangkeluarController::class, 'export'])->name('barangkeluar.export');

route::resource('pengembalian', PengembalianController::class);
Route::get('pengembalian-export', [PengembalianController::class, 'export'])->name('pengembalian.export');

route::resource('pengguna', PenggunaController::class);
});
