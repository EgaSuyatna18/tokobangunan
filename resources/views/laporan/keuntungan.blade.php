@extends('layout.master')
@section('content')
    <link href="/assets/sbadmin2/vendor/datatables/dataTables.bootstrap4.min.css" rel="stylesheet">

    <form action="/laporan/keuntungan/print" method="post">
        @csrf
        <label label for="form-label">Dari</label><input class="form-control w-25 d-inline" type="date" name="from"
            required>
        <label for="form-label">Sampai</label><input class="form-control w-25 d-inline" type="date" name="to"
            required>
        <button class="btn btn-primary mb-2 noPrint" type="submit"><i class="fa fa-print"></i> Print</button>
    </form>
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
                            <th scope="col">Nama Barang</th>
                            <th scope="col">Tanggal</th>
                            <th scope="col">Barang Terjual</th>
                            <th scope="col">Modal</th>
                            <th scope="col">Pendapatan</th>
                            <th scope="col">Keuntungan</th>
                        </tr>
                    </thead>
                    <tbody>
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
                                <td>{{ date('m', strtotime($keuntungan[$i]->tanggal)) . '-' . date('Y', strtotime($keuntungan[$i]->tanggal)) }}
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
                    </tbody>
                    <tr>
                        <td align="right" colspan="7">Total Modal: Rp. {{ number_format($totalModal, 0, ',', '.') }}
                        </td>
                    </tr>
                    <tr>
                        <td align="right" colspan="7">Total Pendapatan: Rp. {{ number_format($totalJual, 0, ',', '.') }}
                        </td>
                    </tr>
                    <tr>
                        <td align="right" colspan="7">Total Untung: Rp.
                            {{ number_format($totalJual - $totalModal, 0, ',', '.') }}
                        </td>
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
