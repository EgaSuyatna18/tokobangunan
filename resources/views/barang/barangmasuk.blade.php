@extends('layout.master')
@section('content')
<a class="btn btn-primary mb-2" href="/barang"><i class="fa fa-arrow-left"></i> Kembali</a>
<table class="table shadow rounded">
    <thead>
      <tr>
        <th scope="col">No</th>
        <th scope="col">Nama Barang</th>
        <th scope="col">Nama User</th>
        <th scope="col">Nama Supplier</th>
        <th scope="col">Jumlah Masuk</th>
        <th scope="col">Tanggal Masuk</th>
      
      </tr>
    </thead>
    <tbody>
      @foreach ($barangMasuk as $bm)
          <tr>
            <td>{{ $loop->index + 1 }}</td>
            <td>{{ $bm->barang->nama_barang }}</td>
            <td>{{ $bm->user->name }}</td>
            <td>{{ $bm->supplier->nama_supplier }}</td>
            <td>{{ $bm->jumlah_masuk }}</td>
            <td>{{date('d-m-Y', strtotime( $bm->tanggal_masuk)) }}</td>
        
          </tr>
      @endforeach
    </tbody>
  </table>
@endsection