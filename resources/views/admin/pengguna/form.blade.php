@extends('admin.layout')
@section('title', $item ? 'Edit Akun' : 'Tambah Akun')
@section('content')
<h1>{{ $item ? 'Edit' : 'Tambah' }} Akun Admin</h1>

@if ($errors->any())
    <div class="notif notif--err">Periksa kembali isian Anda:<ul>@foreach ($errors->all() as $e)<li>{{ $e }}</li>@endforeach</ul></div>
@endif

<form method="POST" class="form" autocomplete="off"
      action="{{ $item ? route('admin.pengguna.update', $item) : route('admin.pengguna.store') }}">
    @csrf
    @if ($item) @method('PUT') @endif

    <label>Nama
        <input type="text" name="name" value="{{ old('name', $item?->name) }}" required maxlength="100">
    </label>
    <label>Email (dipakai untuk login)
        <input type="email" name="email" value="{{ old('email', $item?->email) }}" required maxlength="255">
    </label>
    <label>{{ $item ? 'Password baru (kosongkan bila tidak diubah)' : 'Password' }} (minimal 8 karakter, ada huruf dan angka)
        <input type="password" name="password" minlength="8" autocomplete="new-password" @required(! $item)>
    </label>
    <label>Ulangi password
        <input type="password" name="password_confirmation" minlength="8" autocomplete="new-password" @required(! $item)>
    </label>
    <p class="sub">Semua akun di halaman ini memiliki akses penuh ke panel admin.</p>

    <div class="form__aksi">
        <button type="submit" class="tombol">Simpan</button>
        <a href="{{ route('admin.pengguna.index') }}" class="batal">Batal</a>
    </div>
</form>
@endsection
