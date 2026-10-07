@extends('layouts.app')
@section('title', 'Profil Sekolah - SMKS Islam Bustanul Ulum')
@section('content')
@include('partials.kepala-halaman', ['judul' => 'Profil Sekolah', 'sub' => 'SMKS Islam Bustanul Ulum Pakusari - Jember'])

@use('App\Models\Pengaturan', 'P')
@php
    $sambutan = P::ambil('profil_sambutan');
    $sejarah = P::ambil('profil_sejarah');
    $visi = P::ambil('profil_visi');
    $misi = P::baris('profil_misi');
    $identitas = array_filter([
        'NPSN' => P::ambil('profil_npsn'),
        'Akreditasi' => P::ambil('profil_akreditasi'),
        'Tahun berdiri' => P::ambil('profil_tahun'),
        'Alamat' => P::ambil('alamat'),
        'Telepon' => P::ambil('telepon'),
        'Email' => P::ambil('email'),
    ]);
@endphp

<div class="container isi-hal">
    @if ($sambutan)
        <section class="blok sambutan">
            <div class="sambutan__ikon"><i class="bi bi-quote"></i></div>
            <div>
                <h2>Sambutan Kepala Sekolah</h2>
                <p>{!! nl2br(e($sambutan)) !!}</p>
                @if (P::ambil('profil_kepsek'))<p class="sambutan__nama">{{ P::ambil('profil_kepsek') }}<small>Kepala Sekolah</small></p>@endif
            </div>
        </section>
    @endif

    @if ($sejarah)
        <section class="blok">
            <h2><i class="bi bi-clock-history"></i> Sejarah Singkat</h2>
            <p>{!! nl2br(e($sejarah)) !!}</p>
        </section>
    @endif

    @if ($visi || $misi)
        <section class="blok dua-kartu">
            @if ($visi)
                <div class="kartu-isi"><h2><i class="bi bi-eye-fill"></i> Visi</h2><p>{!! nl2br(e($visi)) !!}</p></div>
            @endif
            @if ($misi)
                <div class="kartu-isi"><h2><i class="bi bi-bullseye"></i> Misi</h2>
                    <ol class="butir">@foreach ($misi as $m)<li>{{ $m }}</li>@endforeach</ol>
                </div>
            @endif
        </section>
    @endif

    @if ($identitas)
        <section class="blok">
            <h2><i class="bi bi-building"></i> Identitas Sekolah</h2>
            <dl class="identitas">
                @foreach ($identitas as $label => $nilai)<div><dt>{{ $label }}</dt><dd>{{ $nilai }}</dd></div>@endforeach
            </dl>
        </section>
    @endif

    @if ($staf->isNotEmpty())
        <section class="blok">
            <h2><i class="bi bi-people-fill"></i> Guru &amp; Staf</h2>
            <div class="staf">
                @foreach ($staf as $s)
                    <figure class="staf__kartu">
                        <div class="staf__foto" @if ($s->foto) style="background-image:url('{{ Storage::disk('public')->url($s->foto) }}')" @endif>
                            @unless ($s->foto){{ mb_strtoupper(mb_substr($s->nama, 0, 1)) }}@endunless
                        </div>
                        <figcaption><b>{{ $s->nama }}</b><small>{{ $s->jabatan }}</small></figcaption>
                    </figure>
                @endforeach
            </div>
        </section>
    @endif

    @if (! $sambutan && ! $sejarah && ! $visi && ! $misi && ! $identitas && $staf->isEmpty())
        <p class="kosong-hal">Informasi profil sekolah sedang disiapkan.</p>
    @endif
</div>
@endsection
