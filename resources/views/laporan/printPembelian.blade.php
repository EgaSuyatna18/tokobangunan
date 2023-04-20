@extends('layout.master')
@section('content')
    <link href="/assets/sbadmin2/vendor/datatables/dataTables.bootstrap4.min.css" rel="stylesheet">


    <table class="table table-bordered">
        <thead>
            <tr>
                <th scope="col">No</th>
                <th scope="col">Nama Barang</th>
                <th scope="col">Nama User</th>
                <th scope="col">Nama Supplier</th>
                <th scope="col">Jumlah Masuk</th>
                <th scope="col">Tanggal Masuk</th>
                <th scope="col">Harga Beli</th>
                <th scope="col">Total Barang</th>
                <th scope="col">Harga Barang</th>
            </tr>
        </thead>
        <tbody>
            @php $total = 0; @endphp
            @foreach ($barangMasuk as $bm)
                @php $total += $bm->barang->harga_beli * $bm->jumlah_masuk @endphp
                <tr>
                    <td>{{ $loop->index + 1 }}</td>
                    <td>{{ $bm->barang->nama_barang }}</td>
                    <td>{{ $bm->user->name }}</td>
                    <td>{{ $bm->supplier->nama_supplier }}</td>
                    <td>{{ $bm->jumlah_masuk }}</td>
                    <td>{{ date('d-m-Y', strtotime($bm->tanggal_masuk)) }}</td>
                    <td>Rp. {{ number_format($bm->barang->harga_beli, 0, ',', '.') }}</td>
                    <td>Rp. {{ number_format($bm->jumlah_masuk * $bm->barang->harga_beli, 0, ',', '.') }}</td>
                    <td>Rp. {{ number_format($bm->barang->harga_barang, 0, ',', '.') }}</td>
                </tr>
            @endforeach
        </tbody>
        <tr>
            <td align="right" colspan="9">Total: Rp. {{ number_format($total, 0, ',', '.') }}</td>
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
