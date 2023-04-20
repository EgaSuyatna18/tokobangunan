@extends('layout.master')
@section('content')
    <link href="/assets/sbadmin2/vendor/datatables/dataTables.bootstrap4.min.css" rel="stylesheet">

    <!-- Button trigger modal -->
    <div class="row">
        <div class="col-12">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Data Barang</h6>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                            <thead>
                                <tr>
                                    <th scope="col">No</th>
                                    <th scope="col">Nama Barang</th>
                                    <th scope="col">Stok</th>
                                    <th scope="col">Jumlah</th>
                                    <th scope="col">Harga Jual</th>
                                    <th scope="col">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($barang as $b)
                                    @csrf
                                    <tr>
                                        <td>{{ $loop->iteration }} </td>
                                        <td>{{ $b->nama_barang }}</td>
                                        <td>{{ $b->stok }}</td>
                                        <form action="{{ url('transaksi/keranjang/' . $b->id) }}" method="GET">
                                            <td width="20px"><input type="number" name="jumlah"
                                                    class="form-control @error('jumlah') is-invalid @enderror"
                                                    min="1" max="{{ $b->stok }}" class="form-control"
                                                    value="0">
                                            </td>
                                            @error('jumlah')
                                                <div class="alert alert-danger">{{ $message }}</div>
                                            @enderror
                                            <td>Rp. {{ number_format($b->harga_barang, 0, ',', '.') }}</td>
                                            <td>
                                                <button type="submit" class="btn btn-success">Masukan Keranjang
                                                </button>
                                            </td>
                                        </form>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-12">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Keranjang</h6>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        @if (empty($cart) || count($cart) == 0)
                            <h5>Keranjang masih kosong!</h5>
                        @else
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th scope="col">No</th>
                                        <th scope="col">Nama Barang</th>
                                        <th scope="col">Harga Barang</th>
                                        <th scope="col">Jumlah</th>
                                        <th scope="col">Sub Total</th>
                                        <th scope="col">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $grand = 0; ?>
                                    @foreach ($cart as $ct => $val)
                                        <?php
                                        $subTotal = $val['jumlah'] * $val['harga_barang'];
                                        $grand += $subTotal;
                                        ?>
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ $val['nama_barang'] }}</td>
                                            <td>{{ number_format($val['harga_barang']) }}</td>
                                            <td>{{ $val['jumlah'] }}</td>
                                            <td>{{ number_format($subTotal) }}</td>
                                            <td>
                                                <a href="{{ url('/transaksi/keranjang/hapus_item/' . $ct) }}"
                                                    class="btn btn-sm btn-danger">Hapus</a>
                                            </td>
                                        </tr>
                                    @endforeach
                                    <tr>
                                        <td colspan="4" align="right"><b>Total Pembelian :</b></td>
                                        <td>{{ number_format($grand) }}</td>
                                        <input type="hidden" id="grand" value="{{ $grand }}">
                                    </tr>
                                    <form action="{{ url('transaksi/simpan') }}" method="POST">
                                        @csrf
                                        <tr>
                                            <td colspan="4" align="right"><b>Jumlah Uang :</b></td>
                                            <td width="150px"><input type="number" min="{{ $grand }}"
                                                    name="bayar" id="bayar" class="form-control" required>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td colspan="4" align="right"><b>Kembalian :</b></td>
                                            <td width="150px"><input type="number" min="{{ $grand }}"
                                                    name="kembalian" class="form-control" id="kembalian" readonly>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td colspan="4" align="right"><b>Nama Pembeli :</b></td>
                                            <td width="150px"><input type="text" name="nama_pembeli"
                                                    class="form-control" required>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td colspan="4" align="right"><b>Metode Pembayaran :</b></td>
                                            <td width="150px">
                                                <select name="metode_pembayaran" id="" class="form-control">
                                                    <option value="Transfer">Transfer</option>
                                                    <option value="Cash">Cash</option>
                                                </select>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td colspan="4" align="right"><b>No Referensi :</b></td>
                                            <td width="150px"><input type="text" name="no_referensi"
                                                    class="form-control" required>
                                            </td>
                                            <td>
                                                <button type="submit" class="btn btn-success">Proses</button>
                                                <a href="{{ url('transaksi/hapus') }}"
                                                    class="btn btn-secondary">Kosongkan</a>
                                            </td>
                                        </tr>
                                    </form>
                                </tbody>
                            </table>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="/assets/sbadmin2/vendor/datatables/jquery.dataTables.min.js"></script>
    <script src="/assets/sbadmin2/js/demo/datatables-demo.js"></script>
    {{-- <script src="https://code.jquery.com/jquery-3.6.3.slim.js"
        integrity="sha256-DKU1CmJ8kBuEwumaLuh9Tl/6ZB6jzGOBV/5YpNE2BWc=" crossorigin="anonymous"></script> --}}
    <script>
        $(document).ready(function() {
            $("#bayar").change(function() {
                var bayar = $("#bayar").val();
                var total = $("#grand").val();
                var kembalian = bayar - total;
                $("#kembalian").val(kembalian);
            });
        })
    </script>
@endsection
