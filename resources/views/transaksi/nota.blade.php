@extends('layout.master')
@section('content')
    <div class="container">
        <div class="row justify-content-between">
            <div class="col-3">
                <p class="m-0">Toko Bangunan UD Bali Bagus</p>
                <p class="m-0">Jalan Hayam Wuruk No.187</p>
                <p class="m-0">Sumerta Kelod Denpasar Timur</p>
                <p class="m-0">No.Telp 0895394592721</p>
            </div>
            <div class="col-3">
                <h3>TOKO BANGUNAN<br>UD BALI BAGUS</h3>
            </div>
        </div>
        <hr>
        <div class="container text-center">
            <h5><b>NOTA PEMBELIAN</b></h5>
            <div class="row justify-content-between text-left">
                <div class="col-4">
                    <table>
                        <tr>
                            <td>Kode Transaksi</td>
                            <td> : {{ $transaksi['kode_transaksi'] }}</td>
                        </tr>
                        <tr>
                            <td>No Referensi</td>
                            <td> : {{ $transaksi['no_referensi'] }}</td>
                        </tr>
                    </table>
                </div>
                <div class="col-4">
                    <table>
                        <tr>
                            <td>Nama Pembeli</td>
                            <td> : {{ $transaksi['nama_pembeli'] }}</td>
                        </tr>
                        <tr>
                            <td>Jenis Pembayaran</td>
                            <td> : {{ $transaksi['jenis_pembayaran'] }}</td>
                        </tr>
                    </table>
                </div>
            </div>
            <table border="1" cellspacing="0" class="w-100">
                <tr>
                    <td>No</td>
                    <td>Nama Barang</td>
                    <td>Jumlah Harga</td>
                    <td>Jumlah Beli</td>
                </tr>
                @php
                    $no = 0;
                    $total = 0;
                @endphp
                @foreach ($penjualan as $barang)
                    @php $total += $barang['sub_total'] @endphp
                    <tr>
                        <td>{{ ++$no }}</td>
                        <td>{{ $barang['nama_barang'] }}</td>
                        <td>{{ number_format($barang['sub_total']) }}</td>
                        <td>{{ $barang['jumlah'] }}</td>
                    </tr>
                @endforeach
                <tr>
                    <td colspan="3" align="center">Total</td>
                    <td>{{ number_format($total) }}</td>
                </tr>
            </table>
            <div class="float-right mt-3">
                <p>Denpasar, {{ date('d-M-Y') }}</p>
                <p>yang menerima,</p>
                <br><br><br>
                <p>(....................................)</p>
            </div>
        </div>
    </div>

    <script>
        window.print();
    </script>
@endsection
