<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'Admin') - SMKS Islam Bustanul Ulum</title>
    <link href="{{ \App\Support\Aset::url('css/fonts.css') }}" rel="stylesheet">
    <link href="{{ asset('vendor/bootstrap-icons/bootstrap-icons.min.css') }}" rel="stylesheet">
    <link href="{{ \App\Support\Aset::url('css/admin.css') }}" rel="stylesheet">
</head>
<body class="admin">
<aside class="side">
    <div class="side__brand">SMKS IBU<small>Panel Admin</small></div>
    @php
        $menu = [
            ['Dashboard', 'admin.dashboard', 'bi-speedometer2', 'admin.dashboard'],
            ['Berita', 'admin.berita.index', 'bi-newspaper', 'admin.berita.*'],
            ['Pengumuman', 'admin.pengumuman.index', 'bi-megaphone-fill', 'admin.pengumuman.*'],
            ['Agenda', 'admin.agenda.index', 'bi-calendar-week-fill', 'admin.agenda.*'],
            ['Galeri', 'admin.galeri.index', 'bi-camera-fill', 'admin.galeri.*'],
            ['Program Keahlian', 'admin.program.index', 'bi-mortarboard-fill', 'admin.program.*'],
            ['Ekstrakurikuler', 'admin.ekstrakurikuler.index', 'bi-people-fill', 'admin.ekstrakurikuler.*'],
            ['Guru & Staf', 'admin.staf.index', 'bi-person-badge-fill', 'admin.staf.*'],
            ['Banner Hero', 'admin.slide.index', 'bi-images', 'admin.slide.*'],
            ['Pengaturan Situs', 'admin.pengaturan', 'bi-gear-fill', 'admin.pengaturan*'],
        ];
    @endphp
    <nav>
        @foreach ($menu as [$nama, $rute, $ikon, $pola])
            <a href="{{ route($rute) }}" class="{{ request()->routeIs($pola) ? 'on' : '' }}"><i class="bi {{ $ikon }}"></i> {{ $nama }}</a>
        @endforeach
    </nav>
    <div class="side__bawah">
        <a href="{{ route('beranda') }}" target="_blank"><i class="bi bi-box-arrow-up-right"></i> Lihat website</a>
        <form method="POST" action="{{ route('logout') }}">@csrf
            <button type="submit"><i class="bi bi-box-arrow-left"></i> Keluar ({{ auth()->user()->name }})</button>
        </form>
    </div>
</aside>
<main class="isi">
    @if (session('ok'))<div class="notif notif--ok">{{ session('ok') }}</div>@endif
    @yield('content')
</main>
</body>
</html>
