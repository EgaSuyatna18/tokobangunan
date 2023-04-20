@extends('layout.master');
@section('content')
    <form action="/profile" method="post">
        @csrf
        @method('put')
        <div class="mb-3">
            <label>Password Lama</label>
            <input type="password" name="lama" class="form-control" required>
        </div>
        <div class="mb-3">
            <label>Password Baru</label>
            <input type="password" name="baru" class="form-control" required>
        </div>
        <div class="mb-3">
            <label>Password Konfirmasi</label>
            <input type="password" name="konfirmasi" class="form-control" required>
        </div>
        <button type="submit" class="btn btn-primary">Submit</button>
    </form>

    @if (session()->has('message')) 
        <script>
            alert("<?= session()->get('message') ?>");
        </script>
    @endif
@endsection