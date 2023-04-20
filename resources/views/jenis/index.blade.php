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
        <th scope="col">Nama Jenis</th>
        <th scope="col">Action</th>
      </tr>
    </thead>
    <tbody>
      @foreach ($jenis as $j)
          <tr>
            <td>{{ $loop->index + 1 }}</td>
            <td>{{ $j->nama_jenis }}</td>
            <td>
                <button type="button" class="btn btn-warning mb-1" data-toggle="modal" data-target="#edit" onclick="setData({{ $j->id }}, '{{ $j->nama_jenis }}')">
                  <i class="fa fa-edit"></i>
                </button>
                <form class="d-inline" action="/jenis/{{ $j->id }}" method="post">
                    @csrf
                    @method('delete')
                    <button type="submit" class="btn btn-danger" onclick="return confirm('delete data?')"><i class="fa fa-trash"></i></button>
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
            <form action="/jenis" method="post" id="formTambah">
                @csrf
                <label>Nama Jenis</label>
                <input class="form-control" type="text" name="nama_jenis" placeholder="Nama Jenis" required>
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
          <h5 class="modal-title" id="exampleModalLabel">Edit Jenis</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
            <form action="/jenis" method="post" id="formEdit">
                @csrf
                @method('put')
                <input type="hidden" name="id" id="editId">
                <label>Nama Jenis</label>
                <input class="form-control" type="text" name="nama_jenis" id="editNamaJenis" placeholder="Nama Jenis" required>
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

<script>
  function setData(id, namaJenis) {
    editId.value = id;
    editNamaJenis.value = namaJenis;
    formEdit.action = '/jenis/' + id;
  }
</script>
@endsection