@extends('layouts.app')
@section('title', 'Kesiswaan - SMKS Islam Bustanul Ulum')
@section('content')
@include('partials.kepala-halaman', ['judul' => 'Kesiswaan', 'sub' => 'Pembinaan karakter, organisasi, dan prestasi siswa'])

@use('App\Models\Pengaturan', 'P')
@php
    $osis = P::ambil('kesiswaan_osis');
    $tertib = P::baris('kesiswaan_tatatertib');
    $beasiswa = P::ambil('kesiswaan_beasiswa');
@endphp

<div class="container isi-hal">
    @if ($osis)
        <section class="blok">
            <h2><i class="bi bi-people-fill"></i> OSIS &amp; Pembinaan Siswa</h2>
            <p>{!! nl2br(e($osis)) !!}</p>
        </section>
    @endif

    <section class="blok">
        <h2><i class="bi bi-trophy-fill"></i> Ekstrakurikuler</h2>
        <div class="program">
            @forelse ($ekskul as $e)
                <div class="program__kartu">
                    <i class="bi {{ $e->ikon }}"></i>
                    <h3>{{ $e->nama }}</h3>
                    @if ($e->deskripsi)<p>{{ $e->deskripsi }}</p>@endif
                    @if ($e->pembina || $e->jadwal)
                        <ul class="meta">
                            @if ($e->pembina)<li><i class="bi bi-person-fill"></i> {{ $e->pembina }}</li>@endif
                            @if ($e->jadwal)<li><i class="bi bi-clock"></i> {{ $e->jadwal }}</li>@endif
                        </ul>
                    @endif
                </div>
            @empty
                <p class="kosong-hal">Daftar ekstrakurikuler belum diisi.</p>
            @endforelse
        </div>
    </section>

    @if ($tertib || $beasiswa)
        <section class="blok dua-kartu">
            @if ($tertib)
                <div class="kartu-isi"><h2><i class="bi bi-shield-check"></i> Tata Tertib</h2>
                    <ol class="butir">@foreach ($tertib as $t)<li>{{ $t }}</li>@endforeach</ol>
                </div>
            @endif
            @if ($beasiswa)
                <div class="kartu-isi"><h2><i class="bi bi-award-fill"></i> Beasiswa &amp; Bantuan</h2><p>{!! nl2br(e($beasiswa)) !!}</p></div>
            @endif
        </section>
    @endif

    @if ($prestasi->isNotEmpty())
        <section class="blok">
            <div class="judul-seksi"><h2><i class="bi bi-stars"></i> Prestasi Terbaru</h2><a href="{{ route('berita') }}" class="lihat">Lihat berita <i class="bi bi-arrow-right"></i></a></div>
            <div class="berita berita--grid">
                @foreach ($prestasi as $b)
                    <article class="kartu">
                        <div class="kartu__gambar" @if ($b->gambar) style="background-image:url('{{ Storage::disk('public')->url($b->gambar) }}')" @endif></div>
                        <div class="kartu__isi">
                            <div class="kartu__meta"><span><i class="bi bi-calendar3"></i> {{ $b->tanggal->translatedFormat('j M Y') }}</span></div>
                            <h3>{{ $b->judul }}</h3>
                            <a href="{{ route('berita.show', $b->slug) }}" class="selengkapnya">Selengkapnya <i class="bi bi-arrow-right"></i></a>
                        </div>
                    </article>
                @endforeach
            </div>
        </section>
    @endif

    @if ($pengumuman->isNotEmpty())
        <section class="blok">
            <div class="judul-seksi"><h2><i class="bi bi-megaphone-fill"></i> Pengumuman Kesiswaan</h2><a href="{{ route('pengumuman') }}" class="lihat">Semua <i class="bi bi-arrow-right"></i></a></div>
            @foreach ($pengumuman as $p)
                <div class="item-tgl">
                    <div class="tgl"><b>{{ $p->tanggal->format('d') }}</b><span>{{ $p->tanggal->translatedFormat('M') }}</span></div>
                    <div><p>{{ $p->judul }}</p></div>
                </div>
            @endforeach
        </section>
    @endif
</div>
@endsection
