<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Barang;
use App\Models\Transaksi;
use App\Models\Penjualan;
use DB;
use Illuminate\Support\Facades\Auth;

class TransaksiController extends Controller
{
    // function index() {
    //     return view('transaksi.index', [
    //         'title' => 'Transaksi',
    //         'barang' => Barang::with(['satuan', 'jenis'])->get()
    //     ]);
    // }

    // // menginput data kedalam session untuk ditampung sebagai pemesanan barang
    // function storeKeranjang(Barang $barang) {
    //     if(Request()->input('jumlah') > $barang->stok) {
    //         return redirect('/transaksi')->withErrors(["Jumlah Exceeds Stok" => 'Stok Tidak Cukup']);
    //     }
    //     session_start();
    //     if(!isset($_SESSION['barang'])) $_SESSION['barang'] = array();
    //     $barang['jumlah'] = 0;
    //     array_push($_SESSION['barang'], $barang);
    //     return redirect('/transaksi');
    // }

    // function keranjang() {
    //     session_start();
    //     return view('transaksi.keranjang', ['title' => 'Keranjang']);
    // }

    // // menghapus data didalam session berdasarkan key yang di kirim
    // function destroyKeranjang($key) {
    //     session_start();
    //     unset($_SESSION['barang'][$key]);
    //     return redirect('/transaksi/keranjang');
    // }

    // // menginput kedalam database data pada session dan menghapus sessionya
    // function proses() {
    //     if(Request()->input('kembali') < 0) abort(403, 'Jumlah Bayar Kurang!');
    //     session_start();
    //     $rules = [
    //         'nama_pembeli' => 'required',
    //         'jenis_pembayaran' => 'required'
    //     ];
    //     if(Request()->input('jenis_pembayaran') == 'Transfer') {
    //         $rules['no_referensi'] = 'required';
    //     }else {
    //         $rules['bayar'] = 'required';
    //         $rules['kembali'] = 'required';
    //     }
    //     $validated = Request()->validate($rules);
    //     if(empty($validated['no_referensi'])) $validated['no_referensi'] = 0;
    //     if(empty($validated['bayar'])) $validated['bayar'] = 0;
    //     if(empty($validated['kembali'])) $validated['kembali'] = 0;
    //     $kode_transaksi = "TRANS" . rand();
    //     $total = 0;
    //     foreach($_SESSION['barang'] as $barang) {
    //         $sub_total = $barang->harga_barang * $barang->jumlah;
    //         $total += $sub_total;
    //         Barang::where('id', $barang->id)->decrement('stok', $barang->jumlah);
    //         Penjualan::create([
    //             'id' => null,
    //             'kode_transaksi' => $kode_transaksi,
    //             'barang_id' => $barang->id,
    //             'jumlah' => $barang->jumlah,
    //             'sub_total' => $sub_total
    //         ]);
    //     }
    //     Transaksi::create([
    //         'id' => null,
    //         'kode_transaksi' => $kode_transaksi,
    //         'user_id' => auth()->user()->id,
    //         'tanggal_transaksi' => DB::raw('now()'),
    //         'total_harga' => $total,
    //         'nama_pembeli' => $validated['nama_pembeli'],
    //         'jenis_pembayaran' => $validated['jenis_pembayaran'],
    //         'no_referensi' => $validated['no_referensi'],
    //         'bayar' => $validated['bayar'],
    //         'kembali' => $validated['kembali']
    //     ]);
    //     return view('transaksi.nota', [
    //         'title' => 'Nota',
    //         'validated' => $validated,
    //         'kode_transaksi' => $kode_transaksi
    //     ]);
    // }

    function penjualan()
    {
        return view('transaksi.penjualan', [
            'title' => 'Penjualan',
            'transaksi' => Transaksi::with('user')->orderBy('created_at', 'DESC')->get()
        ]);
    }

    function detailPenjualan($kode_transaksi)
    {
        return view('transaksi.detailpenjualan', [
            'title' => 'Detail Penjualan',
            'penjualan' => Penjualan::with('barang')->where('kode_transaksi', $kode_transaksi)->get()
        ]);
    }

    function stokKeranjang($id, $stok)
    {
        session_start();
        $total = 0;
        foreach ($_SESSION['barang'] as $k) {
            if ($k['id'] == $id) {
                $k['jumlah'] = $stok;
            }
            $total += $k['harga_barang'] * $k['jumlah'];
        }
        return json_encode([
            'result' => 'Stok Berhasil Diubah',
            'total' => $total
        ]);
    }

    function deleteTransaksi(Transaksi $transaksi)
    {
        $penjualan = Penjualan::where('kode_transaksi', $transaksi->kode_transaksi)->get();
        foreach ($penjualan as $p) {
            Barang::where('id', $p->barang_id)->increment('stok', $p->jumlah);
        }
        Penjualan::where('kode_transaksi', $transaksi->kode_transaksi)->delete();
        Transaksi::where('kode_transaksi', $transaksi->kode_transaksi)->delete();
        return redirect('/transaksi/penjualan');
    }

    public function index()
    {
        $data['cart']       = session("cart");
        $data['barang']     = Barang::all();
        $data['title']      = "Transaksi";
        // session()->forget("cart");
        return view('transaksi.index', $data);
    }

    function tambahKeKeranjang(Request $request)
    {
        $barang = Barang::where('id', $request->id)->first();

        $cart   = session("cart");
        $cart[$request->id]  = [
            "barang_id"     => $barang->id,
            "nama_barang"   => $barang->nama_barang,
            "harga_barang"  => $barang->harga_barang,
            "jumlah"        => $request->jumlah
        ];

        session(["cart" => $cart]);

        return redirect("transaksi");
    }

    function keranjang()
    {
        $data['cart']   = session("cart");
        // dd($data);
        $data['title']  = "Keranjang";
        return view("transaksi.keranjang", $data);
    }

    function hapusItemKeranjang($id)
    {
        $cart   = session("cart");
        unset($cart[$id]);
        session(["cart" => $cart]);
        return redirect('transaksi');
    }

    function simpanTransaksi(Request $request)
    {
        date_default_timezone_set('Asia/Makassar');
        $cart           = session("cart");
        $total_harga    = 0;

        foreach ($cart as $ct => $val) {
            $total_harga    += $val['jumlah'] * $val['harga_barang'];
        }

        $kode_transaksi = Transaksi::max("kode_transaksi");
        $no = substr($kode_transaksi, -1);
        $new_kode_transaksi = "TRANS" . date("dmY") . (int)$no + 1;
        // dd($new_kode_transaksi);

        $transaksi = [
            "kode_transaksi"    => $new_kode_transaksi,
            "user_id"           => Auth::user()->id,
            "tanggal_transaksi" => date('Y-m-d'),
            "total_harga"       => $total_harga,
            "nama_pembeli"      => $request->nama_pembeli,
            "jenis_pembayaran"  => $request->metode_pembayaran,
            "no_referensi"      => $request->no_referensi,
            "bayar"             => $request->bayar,
            "kembali"           => $request->kembalian
        ];

        Transaksi::create($transaksi);

        foreach ($cart as $ct => $val) {
            $total_harga    += $val['jumlah'] * $val['harga_barang'];

            $penjualan = [
                "kode_transaksi"    => $new_kode_transaksi,
                "barang_id"         => $val["barang_id"],
                "jumlah"            => $val["jumlah"],
                "sub_total"         => $val["harga_barang"] * $val["jumlah"]
            ];

            Penjualan::create($penjualan);

            $barang = Barang::where("id", $val["barang_id"])->first();
            $total_stok = $barang->stok - $val['jumlah'];
            $barang->update(['stok' => $total_stok]);
        }

        session()->forget("cart");


        return redirect('transaksi/nota');
    }

    function print()
    {
        $data['transaksi']  = Transaksi::orderBy("id", "desc")->first();
        $transaksi  = Transaksi::orderBy("id", "desc")->first();
        $data['penjualan']  = Penjualan::join("barang", "barang.id", "penjualan.barang_id")
            ->where("kode_transaksi", $transaksi->kode_transaksi)
            ->select("penjualan.*", "barang.nama_barang")
            ->get();
        $data['title'] = "Nota";

        return view('transaksi.nota', $data);
    }

    function hapusKeranjang()
    {
        session()->forget("cart");
        return redirect('transaksi');
    }
}
