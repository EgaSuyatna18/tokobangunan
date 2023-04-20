<?php

namespace App\Http\Controllers;

use App\Models\Transaksi;
use App\Models\BarangMasuk;
use Illuminate\Http\Request;
use DB;

class LaporanController extends Controller
{
    function penjualan()
    {
        return view('/laporan/penjualan', [
            'title' => "Laporan Penjualan",
            'transaksi' => Transaksi::with('user')->orderBy('created_at', 'DESC')->get(),
            'print' => false
        ]);
    }

    // method yang dipanggil apabila tombol print di klik dan akan menjalankan kode js untuk print halaman
    function printPenjualan()
    {
        $validated = Request()->validate([
            'from' => 'required',
            'to' => 'required'
        ]);
        $from = $validated['from'];
        $to = $validated['to'];
        return view('/laporan/printPenjualan', [
            'title' => "Laporan Penjualan",
            'transaksi' => Transaksi::with('user')->orderBy('created_at', 'DESC')->whereBetween('tanggal_transaksi', [$from, $to])->get(),
            'print' => true
        ]);
    }

    function pembelian()
    {
        // dd(BarangMasuk::with(['barang', 'user', 'supplier'])->orderBy('created_at', 'ASC')->get());
        return view('/laporan/pembelian', [
            'title' => "Laporan Pembelian",
            'barangMasuk' => BarangMasuk::with(['barang', 'user', 'supplier'])->orderBy('created_at', 'DESC')->get(),
            'print' => false
        ]);
    }

    // method yang dipanggil apabila tombol print di klik dan akan menjalankan kode js untuk print halaman
    function printPembelian()
    {
        $validated = Request()->validate([
            'from' => 'required',
            'to' => 'required'
        ]);
        $from = $validated['from'];
        $to = $validated['to'];
        // return view('/laporan/pembelian', [
        //     'title' => "Laporan Pembelian",
        //     'barangMasuk' => BarangMasuk::with(['barang', 'user', 'supplier'])->orderBy('created_at', 'ASC')->whereBetween('tanggal_masuk', [$from, $to])->get(),
        //     'print' => true
        // ]);
        $data['barangMasuk'] = BarangMasuk::with(['barang', 'user', 'supplier'])->orderBy('created_at', 'DESC')->whereBetween('tanggal_masuk', [$from, $to])->get();
        $data['print'] = true;
        $data['title'] = "Laporan Pembelian";

        return view("/laporan/printPembelian", $data);
    }

    function keuntungan()
    {
        return view('laporan.keuntungan', [
            'title' => 'Laporan Keuntungan',
            'keuntungan' => DB::select(DB::raw('select barang.nama_barang as nama_barang, barang.harga_beli as harga_beli, barang_masuk.jumlah_masuk * barang.harga_beli as modal, sum(penjualan.sub_total) as pendapatan, sum(penjualan.jumlah) as jumlah, penjualan.created_at as tanggal from barang_masuk inner join barang on barang.id = barang_masuk.barang_id inner join penjualan on penjualan.barang_id = barang_masuk.barang_id group by month(penjualan.created_at), barang.id order by penjualan.created_at asc')),
            'print' => false
        ]);
    }

    function printKeuntungan()
    {
        $validated = Request()->validate([
            'from' => 'required',
            'to' => 'required'
        ]);
        $from = $validated['from'];
        $to = $validated['to'];
        return view('/laporan/print', [
            'title' => "Laporan Keuntungan",
            'keuntungan' => DB::select(DB::raw("select barang.nama_barang as nama_barang, barang.harga_beli as harga_beli, barang_masuk.jumlah_masuk * barang.harga_beli as modal, sum(penjualan.sub_total) as pendapatan, sum(penjualan.jumlah) as jumlah, penjualan.created_at as tanggal from barang_masuk inner join barang on barang.id = barang_masuk.barang_id inner join penjualan on penjualan.barang_id = barang_masuk.barang_id where date(penjualan.created_at) between '$from' and '$to' group by month(penjualan.created_at), barang.id order by penjualan.created_at asc")),
            'from' => $validated['from'],
            'to' => $validated['to'],
            'print' => true
        ]);

        // $validated = Request()->validate([
        //     'from' => 'required',
        //     'to' => 'required'
        // ]);
        // $from = $validated['from'];
        // $to = $validated['to'];

        // $data['keuntungan'] = DB::select(DB::raw('select barang.nama_barang as nama_barang, barang.harga_beli as harga_beli, barang_masuk.jumlah_masuk * barang.harga_beli as modal, sum(penjualan.sub_total) as pendapatan, sum(penjualan.jumlah) as jumlah, penjualan.created_at as tanggal from barang_masuk inner join barang on barang.id = barang_masuk.barang_id inner join penjualan on penjualan.barang_id = barang_masuk.barang_id group by month(penjualan.created_at), barang.id order by penjualan.created_at asc'));
        // $data['title'] = "Laporan Keuntungan";
        // $data['print'] = true;

        // return view('laporan/print', $data);
    }
}
