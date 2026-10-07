@extends('layouts.app')
@section('title', 'Akademik - SMKS Islam Bustanul Ulum')
@section('content')
@include('partials.kepala-halaman', ['judul' => 'Akademik', 'sub' => 'Program keahlian, kurikulum, dan kegiatan belajar'])

@use('App\Models\Pengaturan', 'P')
@php
    $kurikulum = P::ambil('akademik_kurikulum');
    $jam = P::baris('akademik_jam');
    $pkl = P::ambil('akademik_pkl');
@endphp

<div class="container isi-hal">
    <section class="blok">
        <h2><i class="bi bi-mortarboard-fill"></i> Program Keahlian</h2>
        <div class="program">
            @forelse ($program as $pr)
                <div class="program__kartu">
                    <i class="bi {{ $pr->ikon }}"></i>
                    <h3>{{ $pr->nama }}</h3>
                    @if ($pr->deskripsi)<p>{{ $pr->deskripsi }}</p>@endif
                </div>
            @empty
                <p class="kosong-hal">Program keahlian belum diisi.</p>
            @endforelse
        </div>
    </section>

    @if ($kurikulum || $jam)
        <section class="blok dua-kartu">
            @if ($kurikulum)
                <div class="kartu-isi"><h2><i class="bi bi-journal-bookmark-fill"></i> Kurikulum</h2><p>{!! nl2br(e($kurikulum)) !!}</p></div>
            @endif
            @if ($jam)
                <div class="kartu-isi"><h2><i class="bi bi-clock-fill"></i> Jam Belajar</h2>
                    <ul class="butir butir--polos">@foreach ($jam as $j)<li>{{ $j }}</li>@endforeach</ul>
                </div>
            @endif
        </section>
    @endif

    @if ($pkl)
        <section class="blok">
            <h2><i class="bi bi-briefcase-fill"></i> Praktik Kerja Lapangan &amp; Kerja Sama Industri</h2>
            <p>{!! nl2br(e($pkl)) !!}</p>
        </section>
    @endif

    @if ($agenda->isNotEmpty() || $pengumuman->isNotEmpty())
        <section class="blok dua-kartu">
            @if ($agenda->isNotEmpty())
                <div class="kartu-isi">
                    <div class="judul-seksi"><h2><i class="bi bi-calendar-week-fill"></i> Agenda Mendatang</h2><a href="{{ route('agenda') }}" class="lihat">Semua <i class="bi bi-arrow-right"></i></a></div>
                    @foreach ($agenda as $a)
                        <div class="item-tgl item-tgl--garis">
                            <div class="tgl tgl--putih"><b>{{ $a->tanggal->format('d') }}</b><span>{{ $a->tanggal->translatedFormat('M') }}</span></div>
                            <div><p>{{ $a->judul }}</p><small>{{ $a->waktu }}</small></div>
                        </div>
                    @endforeach
                </div>
            @endif
            @if ($pengumuman->isNotEmpty())
                <div class="kartu-isi">
                    <div class="judul-seksi"><h2><i class="bi bi-megaphone-fill"></i> Pengumuman Akademik</h2><a href="{{ route('pengumuman') }}" class="lihat">Semua <i class="bi bi-arrow-right"></i></a></div>
                    @foreach ($pengumuman as $p)
                        <div class="item-tgl">
                            <div class="tgl"><b>{{ $p->tanggal->format('d') }}</b><span>{{ $p->tanggal->translatedFormat('M') }}</span></div>
                            <div><p>{{ $p->judul }}</p></div>
                        </div>
                    @endforeach
                </div>
            @endif
        </section>
    @endif
</div>
@endsection
