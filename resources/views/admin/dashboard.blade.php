@extends('admin.layout')
@section('title', 'Dashboard')
@section('content')
<h1>Dashboard</h1>
<p class="sub">Kelola seluruh konten website dari sini.</p>
<div class="ringkas">
    @foreach ($ringkasan as [$nama, $jumlah, $rute, $ikon])
        <a href="{{ route($rute) }}" class="ringkas__kartu">
            <i class="bi {{ $ikon }}"></i>
            <b>{{ $jumlah }}</b>
            <span>{{ $nama }}</span>
        </a>
    @endforeach
</div>
@endsection
