@extends('layout.master')
@section('content')
    <link href="/assets/sbadmin2/vendor/datatables/dataTables.bootstrap4.min.css" rel="stylesheet">

    <table class="table table-bordered">
        <thead>
            <tr>
                <th scope="col">No</th>
                <th scope="col">Kode Transaksi</th>
                <th scope="col">Nama User</th>
                <th scope="col">Tanggal Transaksi</th>
                <th scope="col">Total Harga</th>
                <th scope="col">Nama Pembeli</th>
                <th scope="col">Jenis Pembayaran</th>
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
                    <td>Rp. {{ number_format($t->total_harga, 0, ',', '.') }}</td>
                    <td>{{ $t->nama_pembeli }}</td>
                    <td>{{ $t->jenis_pembayaran }}</td>
                </tr>
            @endforeach
        </tbody>
        <tr>
            <td align="right" colspan="8">Total Penjualan : Rp. {{ number_format($total, 0, ',', '.') }}</td>
        </tr>
    </table>

    <script src="/assets/sbadmin2/vendor/datatables/jquery.dataTables.min.js"></script>
    <script src="/assets/sbadmin2/js/demo/datatables-demo.js"></script>

    @if ($print)
        <script>
            window.print();
        </script>
    @endif
@endsection
