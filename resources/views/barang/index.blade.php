@extends('layout.master')
@section('content')
    <link href="/assets/sbadmin2/vendor/datatables/dataTables.bootstrap4.min.css" rel="stylesheet">

    <!-- Button trigger modal -->
    <button type="button" class="btn btn-success mb-1" data-toggle="modal" data-target="#tambah">
        <i class="fa fa-plus"></i> Tambah
    </button>
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
                            <th scope="col">Satuan</th>
                            <th scope="col">Jenis</th>
                            <th scope="col">Nama Barang</th>
                            <th scope="col">Stok</th>
                            <th scope="col">Harga Barang</th>
                            <th scope="col">Harga Beli</th>
                            <th scope="col">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($barang as $b)
                            <tr>
                                <td>{{ $loop->index + 1 }}</td>
                                <td>{{ $b->satuan->nama_satuan }}</td>
                                <td>{{ $b->jenis->nama_jenis }}</td>
                                <td>{{ $b->nama_barang }}</td>
                                <td>{{ $b->stok }}</td>
                                <td>Rp. {{ number_format($b->harga_barang, 0, ',', '.') }}</td>
                                <td>Rp. {{ number_format($b->harga_beli, 0, ',', '.') }}</td>
                                <td>
                                    <button type="button" class="btn btn-success mb-1" data-toggle="modal"
                                        data-target="#barangMasuk" onclick="setData2({{ $b->id }})">
                                        Barang Masuk
                                    </button>
                                    <a class="btn btn-info" href="/barangmasuk"><i class="fa fa-info"></i></a>
                                    <button type="button" class="btn btn-warning mb-1" data-toggle="modal"
                                        data-target="#edit"
                                        onclick="setData({{ $b->id }}, '{{ $b->satuan->id }}', '{{ $b->jenis->id }}', '{{ $b->nama_barang }}', {{ $b->harga_barang }}, {{ $b->harga_beli }})">
                                        <i class="fa fa-edit"></i>
                                    </button>
                                    <form class="d-inline" action="/barang/{{ $b->id }}" method="post">
                                        @csrf
                                        @method('delete')
                                        <button type="submit" class="btn btn-danger"
                                            onclick="return confirm('delete data?')"><i class="fa fa-trash"></i></button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    {{-- model collections --}}
    <!-- barang masuk -->
    <div class="modal fade" id="barangMasuk" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Barang Masuk</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="/barangmasuk" method="post" id="formBarangMasuk">
                        @csrf
                        <input type="hidden" name="user_id" value="{{ auth()->user()->id }}">
                        <input type="hidden" name="barang_id" id="tambahBarangMasukId" required>
                        <label>Supplier</label>
                        <select class="form-control mb-2" name="supplier_id" required>
                            @foreach ($supplier as $s)
                                <option value="{{ $s->id }}">{{ $s->nama_supplier }}</option>
                            @endforeach
                        </select>
                        <label>Jumlah Masuk</label>
                        <input class="form-control mb-2" type="number" name="jumlah_masuk" placeholder="Jumlah Masuk"
                            required>
                        <label>Tanggal Masuk</label>
                        <input class="form-control mb-2" type="date" name="tanggal_masuk" required>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary" form="formBarangMasuk">Submit</button>
                </div>
            </div>
        </div>
    </div>
    <!-- tambah -->
    <div class="modal fade" id="tambah" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Tambah Jenis</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="/barang" method="post" id="formTambah">
                        @csrf
                        <label>Satuan</label>
                        <select class="form-control mb-2" name="satuan_id" required>
                            @foreach ($satuan as $s)
                                <option value="{{ $s->id }}">{{ $s->nama_satuan }}</option>
                            @endforeach
                        </select>
                        <label>Jenis</label>
                        <select class="form-control mb-2" name="jenis_id" required>
                            @foreach ($jenis as $j)
                                <option value="{{ $j->id }}">{{ $j->nama_jenis }}</option>
                            @endforeach
                        </select>
                        <label>Nama Barang</label>
                        <input class="form-control mb-2" type="text" name="nama_barang"
                            placeholder="Masukan Nama Barang" required>
                        <label>Harga Jual</label>
                        <input class="form-control mb-2" type="number" name="harga_barang"
                            placeholder="MasukanHarga Jual" required>
                        <label>Harga Beli</label>
                        <input class="form-control mb-2" type="number" name="harga_beli"
                            placeholder="Masukan Harga Beli" required>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary" form="formTambah">Submit</button>
                </div>
            </div>
        </div>
    </div>
    <!-- edit -->
    <div class="modal fade" id="edit" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Edit Barang</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="/barang" method="post" id="formEdit">
                        @csrf
                        @method('put')
                        <input type="hidden" name="id" id="editId">
                        <label>Satuan</label>
                        <select class="form-control mb-2" name="satuan_id" id="editIdSatuan" required>
                            @foreach ($satuan as $s)
                                <option value="{{ $s->id }}">{{ $s->nama_satuan }}</option>
                            @endforeach
                        </select>
                        <label>Jenis</label>
                        <select class="form-control mb-2" name="jenis_id" id="editIdJenis" required>
                            @foreach ($jenis as $j)
                                <option value="{{ $j->id }}">{{ $j->nama_jenis }}</option>
                            @endforeach
                        </select>
                        <label>Nama Barang</label>
                        <input class="form-control mb-2" type="text" name="nama_barang"
                            placeholder="Edit Nama Barang" id="editNamaBarang" required>
                        <label>Harga Jual</label>
                        <input class="form-control mb-2" type="number" name="harga_barang"
                            placeholder="Edit Harga Jual" id="editHargaBarang" required>
                        <label>Harga Beli</label>
                        <input class="form-control mb-2" type="number" name="harga_beli" placeholder="Edit Harga Beli"
                            id="editHargaBeli" required>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary" form="formEdit">Submit</button>
                </div>
            </div>
        </div>
    </div>
    {{-- end model collections --}}

    <script src="/assets/sbadmin2/vendor/datatables/jquery.dataTables.min.js"></script>
    <script src="/assets/sbadmin2/js/demo/datatables-demo.js"></script>

    @if (session()->has('message'))
        <script>
            alert("<?= session()->get('message') ?>");
        </script>
    @endif

    <script>
        function setData(id, idSatuan, idJenis, namaBarang, hargaBarang, hargaBeli) {
            editId.value = id;
            editIdSatuan.value = idSatuan;
            editIdJenis.value = idJenis;
            editNamaBarang.value = namaBarang;
            editHargaBarang.value = hargaBarang;
            editHargaBeli.value = hargaBeli;
            formEdit.action = '/barang/' + id;
        }

        function setData2(id) {
            tambahBarangMasukId.value = id;
        }
    </script>
@endsection
