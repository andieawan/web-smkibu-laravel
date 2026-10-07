@extends('admin.layout')
@section('title', ($item ? 'Edit ' : 'Tambah ') . $judul)
@section('content')
<h1>{{ $item ? 'Edit' : 'Tambah' }} {{ $judul }}</h1>

@if ($errors->any())
    <div class="notif notif--err">Periksa kembali isian Anda:<ul>@foreach ($errors->all() as $e)<li>{{ $e }}</li>@endforeach</ul></div>
@endif

<form method="POST" enctype="multipart/form-data" class="form"
      action="{{ $item ? route('admin.' . $rute . '.update', $item->id) : route('admin.' . $rute . '.store') }}">
    @csrf
    @if ($item) @method('PUT') @endif

    @foreach ($fields as $nama => $f)
        @php $nilai = old($nama, $item?->{$nama}); @endphp
        @if ($nilai instanceof \Carbon\Carbon) @php $nilai = $nilai->format('Y-m-d'); @endphp @endif

        @if ($f['type'] === 'bool')
            <label class="cek"><input type="checkbox" name="{{ $nama }}" value="1" {{ old($nama, $item ? $item->{$nama} : true) ? 'checked' : '' }}> {{ $f['label'] }}</label>
        @else
            <label>{{ $f['label'] }}
            @if ($f['type'] === 'textarea')
                <textarea name="{{ $nama }}" rows="{{ $f['baris'] ?? 3 }}">{{ $nilai }}</textarea>
            @elseif ($f['type'] === 'select')
                <select name="{{ $nama }}">
                    @foreach ($f['opsi'] as $o)<option value="{{ $o }}" @selected($nilai === $o)>{{ $o }}</option>@endforeach
                </select>
            @elseif ($f['type'] === 'image')
                @if ($item && $item->{$nama})<img src="{{ Storage::url($item->{$nama}) }}" class="pratinjau" alt="">@endif
                <input type="file" name="{{ $nama }}" accept="image/*">
            @else
                <input type="{{ $f['type'] }}" name="{{ $nama }}" value="{{ $nilai }}">
            @endif
            </label>
        @endif
    @endforeach

    <div class="form__aksi">
        <button type="submit" class="tombol">Simpan</button>
        <a href="{{ route('admin.' . $rute . '.index') }}" class="batal">Batal</a>
    </div>
</form>
@endsection
