<?php

use App\Http\Controllers\CatatanBarangController;
use App\Http\Controllers\KategoriBarangController;
use App\Http\Controllers\PenggunaController;
use App\Models\KategoriBarang;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('/all-users', [PenggunaController::class, 'index']);
Route::post('/daftar', [PenggunaController::class, 'create']);
Route::post('/masuk', [PenggunaController::class, 'login']);
Route::post('/edit-akun', [PenggunaController::class, 'edit']);
Route::delete('/hapus-akun', [PenggunaController::class, 'destroy']);
Route::get('/download', [PenggunaController::class, 'getdownload']);

Route::get("/kategori-barang", [KategoriBarangController::class, 'index']);
Route::post('/filter-kategori', [KategoriBarangController::class, 'show']);
Route::post('/tambah-kategori-barang', [KategoriBarangController::class, 'create']);
Route::post('/edit-kategori-barang', [KategoriBarangController::class, 'edit']);
Route::delete('/hapus-kategori-barang', [KategoriBarangController::class, 'destroy']);

Route::get('/catatan', [CatatanBarangController::class, 'index']);
Route::post('/filter-catatan', [CatatanBarangController::class, 'show']);
Route::post('/tambah-catatan', [CatatanBarangController::class, 'create']);
Route::post('/edit-catatan', [CatatanBarangController::class, 'edit']);
Route::delete('/hapus-catatan', [CatatanBarangController::class, 'destroy']);