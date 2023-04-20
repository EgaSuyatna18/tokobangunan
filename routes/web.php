<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\PageController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\SatuanController;
use App\Http\Controllers\JenisController;
use App\Http\Controllers\BarangController;
use App\Http\Controllers\SupplierController;
use App\Http\Controllers\BarangMasukController;
use App\Http\Controllers\TransaksiController;
use App\Http\Controllers\LaporanController;
use App\Http\Controllers\ProfileController;

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

// Route::get('/', function () {
//     return view('welcome');
// });

// Page Controller
// mengelola halaman yang tidak memerlukan crud
route::get('/', [PageController::class, 'login']);
route::get('/dashboard', [PageController::class, 'dashboard']);

// User Controller (CRUD)
route::resource('user', UserController::class);
route::put('/user/{id}/admin', [UserController::class, 'updateAdmin']);

// Satuan Controller (CRUD)
route::resource('satuan', SatuanController::class);

// Jenis Controller (CRUD)
route::resource('jenis', JenisController::class);

// Barang Controller (CRUD)
route::resource('barang', BarangController::class);

// Supplier Controller (CRUD)
route::resource('supplier', SupplierController::class);

// Barang Masuk Controller (CRUD)
route::resource('barangmasuk', BarangMasukController::class);

// Transaksi Controller
// mengelola alur transaksi
route::get('/transaksi', [TransaksiController::class, 'index']);
route::get('/transaksi/keranjang/{id}', [TransaksiController::class, 'tambahKeKeranjang']);
route::get('/transaksi/keranjang', [TransaksiController::class, 'keranjang']);
route::get('/transaksi/keranjang/hapus_item/{id}', [TransaksiController::class, 'hapusItemKeranjang']);
route::post('/transaksi/simpan', [TransaksiController::class, 'simpanTransaksi']);
route::get('/transaksi/nota', [TransaksiController::class, 'print']);
route::get('/transaksi/hapus', [TransaksiController::class, 'hapusKeranjang']);
route::get('/transaksi/penjualan', [TransaksiController::class, 'penjualan']);
route::get('/transaksi/penjualan/{penjualan}', [TransaksiController::class, 'detailPenjualan']);
route::get('/transaksi/keranjang/{id}/{stok}', [TransaksiController::class, 'stokKeranjang']);
route::get('/transaksi/penjualan/{transaksi}/delete', [TransaksiController::class, 'deleteTransaksi']);

//  Laporan Controller
// mengelola alur laporan
route::get('/laporan/penjualan', [LaporanController::class, 'penjualan']);
route::get('/laporan/pembelian', [LaporanController::class, 'pembelian']);
route::post('/laporan/penjualan/print', [LaporanController::class, 'printPenjualan']);
route::post('/laporan/pembelian/print', [LaporanController::class, 'printPembelian']);
route::get('/laporan/keuntungan', [LaporanController::class, 'keuntungan']);
route::post('/laporan/keuntungan/print', [LaporanController::class, 'printKeuntungan']);

// profile controller
route::get('/profile', [ProfileController::class, 'index']);
route::put('/profile', [ProfileController::class, 'ubahPassword']);

// Logout
route::get('/logout', function (Request $request) {
    Auth::logout();
    $request->session()->invalidate();
    $request->session()->regenerateToken();
    return redirect('/');
});
