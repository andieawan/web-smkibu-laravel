@extends('admin.layout')
@section('title', 'Pengaturan Situs')
@section('content')
<h1>Pengaturan Situs</h1>

@if ($errors->any())
    <div class="notif notif--err">Periksa kembali isian Anda:<ul>@foreach ($errors->all() as $e)<li>{{ $e }}</li>@endforeach</ul></div>
@endif

<form method="POST" action="{{ route('admin.pengaturan.update') }}" class="form" enctype="multipart/form-data">
    @csrf @method('PUT')
    <h2 class="form__grup">Logo Sekolah</h2>
    <label>Unggah logo (PNG/JPG/WebP, maks. 2 MB; latar transparan lebih bagus)
        @if (! empty($nilai['logo']))<img src="{{ Storage::disk('public')->url($nilai['logo']) }}" class="pratinjau" alt="Logo saat ini">@endif
        <input type="file" name="logo" accept="image/png,image/jpeg,image/webp">
    </label>
    @if (! empty($nilai['logo']))
        <label class="cek"><input type="checkbox" name="hapus_logo" value="1"> Hapus logo ini (kembali ke bawaan)</label>
    @endif

    @foreach ($grup as $namaGrup => $daftar)
        <h2 class="form__grup">{{ $namaGrup }}</h2>
        @foreach ($daftar as $kunci => [$label, $tipe])
            <label>{{ $label }}
                @if ($tipe === 'textarea')
                    <textarea name="{{ $kunci }}" rows="5">{{ old($kunci, $nilai[$kunci] ?? '') }}</textarea>
                @else
                    <input type="text" name="{{ $kunci }}" value="{{ old($kunci, $nilai[$kunci] ?? '') }}">
                @endif
            </label>
        @endforeach
    @endforeach
    <div class="form__aksi"><button type="submit" class="tombol">Simpan</button></div>
</form>
@endsection
