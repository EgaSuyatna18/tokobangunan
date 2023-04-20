<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Barang;
use App\Models\Satuan;
use App\Models\Jenis;
use App\Models\Supplier;
use DB;

class PageController extends Controller
{
    function login() {
        return redirect('/login');
    }

    function dashboard() {
        return view('dashboard', [
            'title' => 'Dashboard',
            'barang' => Barang::get()->count(),
            'satuan' => Satuan::get()->count(),
            'jenis' => Jenis::get()->count(),
            'supplier' => Supplier::get()->count(),
            'bulan1' => DB::select(DB::raw("SELECT IFNULL(SUM(sub_total), 0) AS total FROM penjualan WHERE YEAR(created_at) = YEAR(CURDATE()) AND MONTH(created_at) = 1")),
            'bulan2' => DB::select(DB::raw("SELECT IFNULL(SUM(sub_total), 0) AS total FROM penjualan WHERE YEAR(created_at) = YEAR(CURDATE()) AND MONTH(created_at) = 2")),
            'bulan3' => DB::select(DB::raw("SELECT IFNULL(SUM(sub_total), 0) AS total FROM penjualan WHERE YEAR(created_at) = YEAR(CURDATE()) AND MONTH(created_at) = 3")),
            'bulan4' => DB::select(DB::raw("SELECT IFNULL(SUM(sub_total), 0) AS total FROM penjualan WHERE YEAR(created_at) = YEAR(CURDATE()) AND MONTH(created_at) = 4")),
            'bulan5' => DB::select(DB::raw("SELECT IFNULL(SUM(sub_total), 0) AS total FROM penjualan WHERE YEAR(created_at) = YEAR(CURDATE()) AND MONTH(created_at) = 5")),
            'bulan6' => DB::select(DB::raw("SELECT IFNULL(SUM(sub_total), 0) AS total FROM penjualan WHERE YEAR(created_at) = YEAR(CURDATE()) AND MONTH(created_at) = 6")),
            'bulan7' => DB::select(DB::raw("SELECT IFNULL(SUM(sub_total), 0) AS total FROM penjualan WHERE YEAR(created_at) = YEAR(CURDATE()) AND MONTH(created_at) = 7")),
            'bulan8' => DB::select(DB::raw("SELECT IFNULL(SUM(sub_total), 0) AS total FROM penjualan WHERE YEAR(created_at) = YEAR(CURDATE()) AND MONTH(created_at) = 8")),
            'bulan9' => DB::select(DB::raw("SELECT IFNULL(SUM(sub_total), 0) AS total FROM penjualan WHERE YEAR(created_at) = YEAR(CURDATE()) AND MONTH(created_at) = 9")),
            'bulan10' => DB::select(DB::raw("SELECT IFNULL(SUM(sub_total), 0) AS total FROM penjualan WHERE YEAR(created_at) = YEAR(CURDATE()) AND MONTH(created_at) = 10")),
            'bulan11' => DB::select(DB::raw("SELECT IFNULL(SUM(sub_total), 0) AS total FROM penjualan WHERE YEAR(created_at) = YEAR(CURDATE()) AND MONTH(created_at) = 11")),
            'bulan12' => DB::select(DB::raw("SELECT IFNULL(SUM(sub_total), 0) AS total FROM penjualan WHERE YEAR(created_at) = YEAR(CURDATE()) AND MONTH(created_at) = 12"))
        ]);
    }
}