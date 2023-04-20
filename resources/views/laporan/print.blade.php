@extends('layout.master')
@section('content')
    <link href="/assets/sbadmin2/vendor/datatables/dataTables.bootstrap4.min.css" rel="stylesheet">
    <table class="table table-bordered">
            <tr>
                <th>No</th>
                <th>Nama Barang</th>
                <th>Tanggal</th>
                <th>Barang Terjual</th>
                <th>Modal</th>
                <th>Pendapatan</th>
                <th>Keuntungan</th>
            </tr>
            @php
                $barang = '';
                $totalBeli = 0;
                $totalJual = 0;
                $totalUntung = 0;
                $totalModal = 0;
            @endphp
            @for ($i = 0; $i < count((array) $keuntungan); $i++)
                @php
                    if ($barang != $keuntungan[$i]->nama_barang) {
                        $barang = $keuntungan[$i]->nama_barang;
                        $pendapatan = 0;
                    }
                    $pendapatan += $keuntungan[$i]->pendapatan;
                    $totalBeli += $keuntungan[$i]->modal;
                    $totalJual += $keuntungan[$i]->pendapatan;
                    $totalUntung += $totalJual - $totalBeli;
                @endphp
                <tr>
                    <td>{{ $i + 1 }}</td>
                    <td>{{ $keuntungan[$i]->nama_barang }}</td>
                    <td>{{ date('F', strtotime($keuntungan[$i]->tanggal)) . '-' . date('Y', strtotime($keuntungan[$i]->tanggal)) }}
                    </td>
                    <td>{{ number_format($keuntungan[$i]->jumlah, 0, ',', '.') }}</td>
                    <td>Rp.
                        {{ number_format($modal = $keuntungan[$i]->harga_beli * $keuntungan[$i]->jumlah, 0, ',', '.') }}
                    </td>
                    <td>Rp. {{ number_format($pendapatan = $keuntungan[$i]->pendapatan, 0, ',', '.') }}</td>
                    <td>Rp. {{ number_format($pendapatan - $modal, 0, ',', '.') }}</td>
                </tr>
                @php
                    $totalModal += $modal;
                @endphp
            @endfor
            <tr>
                <td colspan="7" align="right">Total Modal: Rp. {{ number_format($totalModal, 0, ',', '.') }}</td>
            </tr>
            <tr>
                <td colspan="7" align="right">Total Pendapatan: Rp. {{ number_format($totalJual, 0, ',', '.') }}
                </td>
            </tr>
            <tr>
                <td colspan="7" align="right">Total Untung:
                    Rp. {{ number_format($totalJual - $totalModal, 0, ',', '.') }}</td>
            </tr>
    </table>

    <script src="https://cdn.jsdelivr.net/npm/jquery@3.5.1/dist/jquery.slim.min.js"
        integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-Fy6S3B9q64WdZWQUiU+q4/2Lc9npb8tCaSX9FK7E8HnRr0Jz8D6OP9dO5Vg3Q9ct" crossorigin="anonymous">
    </script>
    @if ($print)
    <script>
        window.print();
    </script>
@endif
@endsection
