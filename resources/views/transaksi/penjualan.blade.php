@extends('layout.master')
@section('content')
<link href="/assets/sbadmin2/vendor/datatables/dataTables.bootstrap4.min.css" rel="stylesheet">

<!-- Button trigger modal -->
<div class="card shadow mb-4">
  <div class="card-header py-3">
      <h6 class="m-0 font-weight-bold text-primary">DataTables</h6>
  </div>
  <div class="card-body">
      <div class="table-responsive">
        <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
    <thead>
      <tr>
        <th scope="col">No</th>
        <th scope="col">Kode Transaksi</th>
        <th scope="col">Nama User</th>
        <th scope="col">Tanggal Transaksi</th>
        <th scope="col">Total Harga</th>
        <th scope="col">Nama Pembeli</th>
        <th scope="col">Jenis Pembayaran</th>
        <th scope="col">No Referensi</th>
        <th scope="col">Action</th>
      </tr>
    </thead>
    <tbody>
        @foreach ($transaksi as $t)
            <tr>
                <td>{{ $loop->index + 1 }}</td>
                <td>{{ $t->kode_transaksi }}</td>
                <td>{{ $t->user->name }}</td>
                <td>{{ date("d-m-Y", strtotime($t->tanggal_transaksi)) }}</td>
                <td>{{ number_format($t->total_harga) }}</td>
                <td>{{ $t->nama_pembeli }}</td>
                <td>{{ $t->jenis_pembayaran }}</td>
                <td>{{ $t->no_referensi}}</td>
                <td>
                    <a class="btn btn-info" href="/transaksi/penjualan/{{ $t->kode_transaksi }}"><i class="fa fa-eye"></i></a>
                    <br></br>
                    @if (auth()->user()->level == 'Pemilik')
                    <a class="btn btn-danger" href="/transaksi/penjualan/{{ $t->id }}/delete" onclick="return confirm('Hapus Data?')"><i class="fa fa-trash"></i></a>
                    @endif
                  </td>
            </tr>
        @endforeach
    </tbody>
  </table>
</div>
</div>
</div>

<script src="/assets/sbadmin2/vendor/datatables/jquery.dataTables.min.js"></script>
<script src="/assets/sbadmin2/js/demo/datatables-demo.js"></script>
@endsection