@extends('admin.layout')
@section('title', 'Pengguna')
@section('content')
<div class="kepala">
    <h1>Pengguna Admin</h1>
    <a href="{{ route('admin.pengguna.create') }}" class="tombol">+ Tambah akun</a>
</div>

@if ($errors->any())
    <div class="notif notif--err">@foreach ($errors->all() as $e){{ $e }}@endforeach</div>
@endif

<div class="tabel-bungkus">
<table class="tabel">
    <thead><tr><th>Nama</th><th>Email</th><th>Dibuat</th><th style="width:150px">Aksi</th></tr></thead>
    <tbody>
    @foreach ($items as $u)
        <tr>
            <td>{{ $u->name }} @if ($u->is(auth()->user()))<small>(Anda)</small>@endif</td>
            <td>{{ $u->email }}</td>
            <td>{{ $u->created_at?->translatedFormat('d M Y') }}</td>
            <td class="aksi">
                <a href="{{ route('admin.pengguna.edit', $u) }}">Edit</a>
                @unless ($u->is(auth()->user()))
                    <form method="POST" action="{{ route('admin.pengguna.destroy', $u) }}" onsubmit="return confirm('Hapus akun {{ $u->email }}?')">
                        @csrf @method('DELETE')
                        <button type="submit" class="hapus">Hapus</button>
                    </form>
                @endunless
            </td>
        </tr>
    @endforeach
    </tbody>
</table>
</div>
<div class="halaman">{{ $items->links() }}</div>
@endsection
