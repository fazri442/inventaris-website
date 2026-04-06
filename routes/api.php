<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/



Route::post('/register', [\App\Http\Controllers\Api\AuthController::class, 'register']);
Route::post('/login', [\App\Http\Controllers\Api\AuthController::class, 'login']);

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::middleware('auth:sanctum')->group(function () {
    Route::post('/logout', [\App\Http\Controllers\Api\AuthController::class, 'logout']);
    Route::resource('/tim', \App\Http\Controllers\Api\TimApiController::class)->except(['create', 'edit']);
    
    Route::resource('/barangkeluar', \App\Http\Controllers\Api\BarangKeluarApiController::class)->except(['create', 'edit']);
    Route::resource('/datapusat', \App\Http\Controllers\Api\DataPusatApiController::class)->except(['create', 'edit']);
    Route::resource('/barangmasuk', \App\Http\Controllers\Api\BarangMasukApiController::class)->except(['create', 'edit']);
    Route::resource('/barangkeluar', \App\Http\Controllers\Api\BarangKeluarApiController::class)->except(['create', 'edit']);
    Route::resource('/peminjaman', \App\Http\Controllers\Api\PeminjamApiController::class)->except(['create', 'edit']);
    Route::resource('/pengembalian', \App\Http\Controllers\Api\PengembalianApiController::class)->except(['create', 'edit']);
});
