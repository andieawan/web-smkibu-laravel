@extends('admin.layout')
@section('title', $judul)
@section('content')
<div class="kepala">
    <h1>{{ $judul }}</h1>
    <a href="{{ route('admin.' . $rute . '.create') }}" class="tombol">+ Tambah</a>
</div>
<div class="tabel-bungkus">
<table class="tabel">
    <thead><tr>
        @foreach ($kolom as $label => $atribut)<th>{{ $label }}</th>@endforeach
        <th style="width:130px">Aksi</th>
    </tr></thead>
    <tbody>
    @forelse ($items as $item)
        <tr>
            @foreach ($kolom as $atribut)
                @php $v = $item->{$atribut}; @endphp
                <td>
                    @if ($v instanceof \Carbon\Carbon) {{ $v->translatedFormat('d M Y') }}
                    @elseif (is_bool($v)) {{ $v ? 'Ya' : 'Tidak' }}
                    @else {{ \Illuminate\Support\Str::limit((string) $v, 70) }}
                    @endif
                </td>
            @endforeach
            <td class="aksi">
                <a href="{{ route('admin.' . $rute . '.edit', $item->id) }}">Edit</a>
                <form method="POST" action="{{ route('admin.' . $rute . '.destroy', $item->id) }}" onsubmit="return confirm('Hapus data ini?')">
                    @csrf @method('DELETE')
                    <button type="submit" class="hapus">Hapus</button>
                </form>
            </td>
        </tr>
    @empty
        <tr><td colspan="{{ count($kolom) + 1 }}" class="kosong">Belum ada data.</td></tr>
    @endforelse
    </tbody>
</table>
</div>
<div class="halaman">{{ $items->links() }}</div>
@endsection
