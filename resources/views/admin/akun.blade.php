@extends('admin.layout')
@section('title', 'Akun Saya')
@section('content')
<h1>Akun Saya</h1>

@if ($errors->any())
    <div class="notif notif--err">Periksa kembali isian Anda:<ul>@foreach ($errors->all() as $e)<li>{{ $e }}</li>@endforeach</ul></div>
@endif

<form method="POST" action="{{ route('admin.akun.profil') }}" class="form">
    @csrf @method('PUT')
    <h2 class="form__grup">Data akun</h2>
    <label>Nama
        <input type="text" name="name" value="{{ old('name', $user->name) }}" required maxlength="100">
    </label>
    <label>Email (dipakai untuk login)
        <input type="email" name="email" value="{{ old('email', $user->email) }}" required maxlength="255">
    </label>
    <div class="form__aksi"><button type="submit" class="tombol">Simpan data</button></div>
</form>

<form method="POST" action="{{ route('admin.akun.password') }}" class="form" autocomplete="off">
    @csrf @method('PUT')
    <h2 class="form__grup">Ganti password</h2>
    <label>Password saat ini
        <input type="password" name="password_lama" required autocomplete="current-password">
    </label>
    <label>Password baru (minimal 8 karakter, ada huruf dan angka)
        <input type="password" name="password" required minlength="8" autocomplete="new-password">
    </label>
    <label>Ulangi password baru
        <input type="password" name="password_confirmation" required minlength="8" autocomplete="new-password">
    </label>
    <p class="sub">Setelah password diganti, sesi login Anda di perangkat lain otomatis keluar.</p>
    <div class="form__aksi"><button type="submit" class="tombol">Ganti password</button></div>
</form>
@endsection
