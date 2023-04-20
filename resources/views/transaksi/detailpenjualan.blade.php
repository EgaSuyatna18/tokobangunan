@extends('layout.master')
@section('content')
<a class="btn btn-primary mb-2" href="/transaksi/penjualan"><i class="fa fa-arrow-left"></i> Kembali</a>
<table class="table">
    <thead>
      <tr>
        <th scope="col">No</th>
        <th scope="col">Nama Barang</th>
        <th scope="col">Jumlah</th>
        <th scope="col">Sub Total</th>
      </tr>
    </thead>
    <tbody>
        @foreach ($penjualan as $p)
            <tr>
                <td>{{ $loop->index + 1 }}</td>
                <td>{{ $p->barang->nama_barang }}</td>
                <td>{{ $p->jumlah }}</td>
                <td>{{ $p->sub_total }}</td>
            </tr>
        @endforeach
    </tbody>
  </table>
@endsection