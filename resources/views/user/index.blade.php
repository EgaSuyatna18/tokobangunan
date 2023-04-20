@extends('layout.master')
@section('content')
<link href="/assets/sbadmin2/vendor/datatables/dataTables.bootstrap4.min.css" rel="stylesheet">

<!-- Button trigger modal -->
<button type="button" class="btn btn-success mb-1" data-toggle="modal" data-target="#tambah">
  <i class="fa fa-plus"></i> Tambah
</button>

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
        <th scope="col">Name</th>
        <th scope="col">Username</th>
        <th scope="col">No Telp</th>
        <th scope="col">Level</th>
        <th scope="col">Action</th>
      </tr>
    </thead>
    <tbody>
      @foreach ($users as $user)
          <tr>
            <td>{{ $loop->index + 1 }}</td>
            <td>{{ $user->name }}</td>
            <td>{{ $user->username }}</td>
            <td>{{ $user->no_telp }}</td>
            <td>{{ $user->level }}</td>
            <td>
              @if ($user->username == 'admin')
                  <button type="button" class="btn btn-warning mb-1 d-inline" data-toggle="modal" data-target="#editAdmin"
                  onclick="setDataAdmin('{{ $user->id }}', '{{ $user->no_telp }}')">
                    <i class="fa fa-edit"></i>
                  </button>
              @else
              <form class="d-inline" action="/user/{{ $user->id }}" method="post">
                @csrf
                @method('delete')
                <button class="btn btn-danger" onclick="return confirm('Hapus Data?')"><i class="fa fa-trash"></i></button>
              </form>
              <button type="button" class="btn btn-warning mb-1 d-inline" data-toggle="modal" data-target="#edit"
              onclick="setData('{{ $user->id }}', '{{ $user->name }}', '{{ $user->username }}', '{{ $user->no_telp }}', '{{ $user->level }}')">
                <i class="fa fa-edit"></i>
              </button>
              @endif
            </td>
          </tr>
      @endforeach
    </tbody>
  </table>
</div>
</div>
</div>

{{-- modals collections --}}
<!-- Tambah -->
<div class="modal fade" id="tambah" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Tambah User</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form action="/user" method="post" id="formTambah">
          @csrf
          <label>Nama</label>
          <input class="form-control mb-2" type="text" name="name" placeholder="Masukan Nama" required>
          <label>Username</label>
          <input class="form-control mb-2" type="text" name="username" placeholder="Masukan Username" required>
          <label>No Telp</label>
          <input class="form-control mb-2" type="number" name="no_telp" placeholder="Masukan No Telp" required>
          <label>Level</label>
          <select class="form-control mb-2" name="level" required>
            <option value="">--Pilih Level--</option>
            <option value="Pemilik">Pemilik</option>
            <option value="Pegawai">Pegawai</option>
          </select>
          <label>Password</label>
          <input class="form-control" type="text" name="password" placeholder="Masukan Password" required>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-primary" form="formTambah">Submit</button>
      </div>
    </div>
  </div>
</div>

{{-- edit --}}
<div class="modal fade" id="edit" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Edit User</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form action="/user" method="post" id="formEdit">
          @csrf
          @method('put')
          <input type="hidden" name="id" id="editId">
          <label>Nama</label>
          <input class="form-control mb-2" type="text" name="name" placeholder="Masukan Nama" id="editName" required>
          <label>Username</label>
          <input class="form-control mb-2" type="text" name="username" placeholder="Masukan Username" id="editUsername" required>
          <label>No Telp</label>
          <input class="form-control mb-2" type="number" name="no_telp" placeholder="Masukan No Telp" id="editNoTelp" required>
          <label>Level</label>
          <select class="form-control mb-2" name="level">
            <option value="">--Pilih Level--</option>
            <option value="Pemilik" id="editPemilik">Pemilik</option>
            <option value="Pegawai" id="editPegawai">Pegawai</option>
          </select>
          <label>Password</label>
          <input class="form-control" type="text" name="password" placeholder="Masukan Password (Abaikan bila tidak di ubah)">
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-primary" form="formEdit">Submit</button>
      </div>
    </div>
  </div>
</div>

{{-- edit admin --}}
<div class="modal fade" id="editAdmin" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Edit User</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form action="/user/" method="post" id="formEditAdmin">
          @csrf
          @method('put')
          <input type="hidden" name="id" id="editId">
          <label>No Telp</label>
          <input class="form-control mb-2" type="number" name="no_telp" placeholder="No Telp" id="editNoTelpAdmin" required>
          <label>Password</label>
          <input class="form-control" type="text" name="password" placeholder="Password (Abaikan bila tidak di ubah)" required>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-primary" form="formEditAdmin">Submit</button>
      </div>
    </div>
  </div>
</div>
{{-- end modals conllections --}}

<script src="/assets/sbadmin2/vendor/datatables/jquery.dataTables.min.js"></script>
<script src="/assets/sbadmin2/js/demo/datatables-demo.js"></script>

  <script>
    function setData(id, name, username, noTelp, level) {
      editId.value = id;
      editName.value = name;
      editUsername.value = username;
      editNoTelp.value = noTelp;
      if(level == 'Pemilik') {
        editPemilik.selected = 'selected';
      }else {
        editPegawai.selected = 'selected';
      }
      formEdit.action = '/user/' + id;
    }

    function setDataAdmin(id, noTelp) {
      console.log("asd");
      formEditAdmin.action = '/user/' + id + '/admin';
      editNoTelpAdmin.value = noTelp;
      console.log(formEditAdmin.action);
    }
  </script>
@endsection