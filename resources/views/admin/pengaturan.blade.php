@extends('admin.layout')
@section('title', 'Pengaturan Situs')
@section('content')
<h1>Pengaturan Situs</h1>
<form method="POST" action="{{ route('admin.pengaturan.update') }}" class="form">
    @csrf @method('PUT')
    @foreach ($daftar as $kunci => [$label, $tipe])
        <label>{{ $label }}
            @if ($tipe === 'textarea')
                <textarea name="{{ $kunci }}" rows="5">{{ old($kunci, $nilai[$kunci] ?? '') }}</textarea>
            @else
                <input type="text" name="{{ $kunci }}" value="{{ old($kunci, $nilai[$kunci] ?? '') }}">
            @endif
        </label>
    @endforeach
    <div class="form__aksi"><button type="submit" class="tombol">Simpan</button></div>
</form>
@endsection
