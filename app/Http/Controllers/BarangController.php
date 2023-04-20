<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Satuan;
use App\Models\Jenis;
use App\Models\Supplier;
use App\Models\Barang;
use App\Models\BarangMasuk;

class BarangController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('barang.index', [
            'title' => 'Barang',
            'satuan' => Satuan::all(),
            'jenis' => Jenis::all(),
            'supplier' => Supplier::all(),
            'barang' => Barang::with(['satuan', 'jenis'])->get()
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validated = Request()->validate([
            'satuan_id' => 'required',
            'jenis_id' => 'required',
            'nama_barang' => 'required',
            'harga_barang' => 'required',
            'harga_beli' => 'required'
        ]);
        if($validated['harga_beli'] >= $validated['harga_barang']){
            return redirect('/barang')->with('message', 'Harga Beli Lebih Besar!'); 
        }
        Barang::create($validated);
        return redirect('/barang');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'satuan_id' => 'required',
            'jenis_id' => 'required',
            'nama_barang' => 'required',
            'harga_barang' => 'required',
            'harga_beli' => 'required'
        ]);
        if($validated['harga_beli'] >= $validated['harga_barang']){
            return redirect('/barang')->with('message', 'Harga Beli Lebih  Besar!'); 
        }
        Barang::where('id', $request->input('id'))->update($validated);
        return redirect('/barang');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Barang::where('id', $id)->delete();
        BarangMasuk::where('barang_id', $id)->delete();
        return redirect('/barang');
    }
}