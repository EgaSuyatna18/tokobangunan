@extends('layout.master')
@section('content')
    {{-- {{ dd($_SESSION['barang']) }} --}}
    @if (isset($_SESSION['barang']))
        <button type="button" class="btn btn-success mb-1" data-toggle="modal" data-target="#tambah">
            <i class="fa fa-cog"></i> Proses
        </button>
    @endif

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
                    <th scope="col">Action</th>
                </tr>
            </thead>
            <tbody>
                <?php $grandTotal = 0; ?>
                @foreach ($cart as $ct => $val)
                    <?php
                    $subTotal = $val['jumlah'] * $val['harga_barang'];
                    $grandTotal += $subTotal;
                    ?>
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $val['nama_barang'] }}</td>
                        <td>Rp. {{ number_format($val['harga_barang'], 0, ',', '.') }}</td>
                        <td>{{ $val['jumlah'] }}</td>
                        <td>Rp. {{ number_format($subTotal, 0, ',', '.') }}</td>
                        <td>
                            <a href="{{ url('/transaksi/keranjang/hapus_item/' . $ct) }}"
                                class="btn btn-sm btn-danger">Hapus</a>
                        </td>
                    </tr>
                @endforeach
                <tr>
                    <td colspan="4" align="right"><b>Total Pembelian :</b></td>
                    <td>Rp. {{ number_format($grandTotal, 0, ',', '.') }}</td>
                    <td>
                        <a href="{{ url('transaksi/simpan') }}" class="btn btn-success">Proses</a>
                        <a href="{{ url('transaksi/hapus') }}" class="btn btn-danger">Hapus Keranjang</a>
                    </td>
                </tr>
            </tbody>
        </table>
    @endif

    {{-- <table class="table">
        <thead>
            <tr>
                <th scope="col">No</th>
                <th scope="col">Nama Barang</th>
                <th scope="col">Harga Barang</th>
                <th scope="col">Jumlah</th>
                <th scope="col">Sub Total</th>
                <th scope="col">Action</th>
            </tr>
        </thead>
        <tbody>
            @if (isset($_SESSION['barang']))
                @foreach ($_SESSION['barang'] as $key => $barang)
                    <tr>
                        <td>{{ $loop->index + 1 }}</td>
                        <td>{{ $barang['nama_barang'] }}</td>
                        <td>{{ number_format($barang['harga_barang']) }}</td>
                        <td>
                            <input type="number" min="0" style="width: 50px;" value="{{ $barang['jumlah'] }}"
                                onchange="setStok({{ $barang['id'] }}, this.value, {{ $barang['harga_barang'] }}, this)">
                        </td>
                        <td>{{ number_format($barang['jumlah'] * $barang['harga_barang']) }}</td>
                        <td>
                            <a class="btn btn-danger" href="/transaksi/keranjang/{{ $key }}/delete"
                                onclick="return confirm('hapus data?')"><i class="fa fa-trash"></i></a>
                        </td>
                    </tr>
                @endforeach
                <tr>
                    <td colspan="4" align="center">Total</td>
                    <td colspan="2" id="total"></td>
                </tr>
            @endif
        </tbody>
    </table> --}}

    {{-- model collections --}}
    <!-- tambah -->
    {{-- <div class="modal fade" id="tambah" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Proses</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="/transaksi/proses" method="post" id="formTambah">
                        @csrf
                        <input class="form-control mb-2" type="text" name="nama_pembeli" placeholder="Nama Pembeli">
                        <select class="form-control mb-2" name="jenis_pembayaran" onchange="setSelect(this)">
                            <option>Transfer</option>
                            <option>Cash</option>
                        </select>
                        <input class="form-control mb-2" id="no_referensi" type="number" name="no_referensi"
                            placeholder="No Referensi">
                        <input class="form-control mb-2 d-none" id="bayar" type="number" name="bayar"
                            placeholder="Uang yang dibayarkan" onkeyup="setKembali(this)">
                        <input class="form-control d-none" id="kembali" type="number" name="kembali"
                            placeholder="Kembali" readonly>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary" form="formTambah">Submit</button>
                </div>
            </div>
        </div>
    </div> --}}
    {{-- end model collections --}}
    {{-- @if (isset($_SESSION['barang']) && count($_SESSION['barang']))
        <script>
            let letTotal = 0;

            function setStok(id, value, harga, t) {
                const xhr = new XMLHttpRequest();
                xhr.open("GET", `{{ URL::to('/transaksi/keranjang/') }}/${id}/${value}`);
                xhr.send();
                xhr.onload = function(e) {
                    if (this.readyState === XMLHttpRequest.DONE && this.status === 200) {
                        if (t != null) t.parentNode.nextElementSibling.innerHTML = (value * harga).toLocaleString('en-US');
                        var response = JSON.parse(xhr.responseText);
                        total.innerHTML = response.total.toLocaleString('en-US');
                        letTotal = response.total;
                    }
                }
            }


            function setSelect(select) {
                let selectValue = select.value;
                if (selectValue == 'Transfer') {
                    bayar.classList.add('d-none');
                    kembali.classList.add('d-none');
                    no_referensi.classList.remove('d-none');
                } else if (selectValue == 'Cash') {
                    no_referensi.classList.add('d-none');
                    bayar.classList.remove('d-none');
                    kembali.classList.remove('d-none');
                }
            }

            function setKembali(bayar) {
                kembali.value = bayar.value - letTotal;
            }
            setStok({{ $_SESSION['barang']['0']['id'] . ',' . $_SESSION['barang']['0']['jumlah'] . ',' . $_SESSION['barang']['0']['harga_barang'] }},
                null);
        </script>
    @endif --}}
@endsection
