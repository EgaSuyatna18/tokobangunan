@extends('layout.master')
@section('content')
    <link href="/assets/sbadmin2/vendor/datatables/dataTables.bootstrap4.min.css" rel="stylesheet">

    <form action="/laporan/penjualan/print" method="post">
        @csrf
        <label label for="form-label">Dari</label><input class="form-control w-25 d-inline" type="date" name="from"
            required>
        <label for="form-label">Sampai</label><input class="form-control w-25 d-inline" type="date" name="to"
            required>
        <button class="btn btn-primary mb-2 noPrint" type="submit"><i class="fa fa-print"></i> Print</button>
    </form>
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
                            <th scope="col">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php $total = 0; @endphp
                        @foreach ($transaksi as $t)
                            @php $total += $t->total_harga @endphp
                            <tr>
                                <td>{{ $loop->index + 1 }}</td>
                                <td>{{ $t->kode_transaksi }}</td>
                                <td>{{ $t->user->name }}</td>
                                <td>{{ date('d-m-Y', strtotime($t->tanggal_transaksi)) }}</td>
                                <td>{{ number_format($t->total_harga) }}</td>
                                <td>{{ $t->nama_pembeli }}</td>
                                <td>{{ $t->jenis_pembayaran }}</td>
                                <td>
                                    <a class="btn btn-info" href="/transaksi/penjualan/{{ $t->kode_transaksi }}"><i
                                            class="fa fa-eye"></i></a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                    <tr>
                        <td align="right" colspan="8">Total Penjualan : {{ number_format($total) }}</td>
                    </tr>
                </table>
            </div>
        </div>
    </div>

    <script src="/assets/sbadmin2/vendor/datatables/jquery.dataTables.min.js"></script>
    <script src="/assets/sbadmin2/js/demo/datatables-demo.js"></script>

    @if ($print)
        <script>
            window.print();
        </script>
    @endif
@endsection
