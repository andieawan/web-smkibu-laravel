<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'SMKS Islam Bustanul Ulum Pakusari - Jember')</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&family=Playfair+Display:ital,wght@1,600&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
    <link href="{{ asset('css/site.css') }}" rel="stylesheet">
</head>
<body>

{{-- Topbar --}}
<div class="topbar">
    <div class="container topbar__inner">
        <div class="topbar__info">
            <span><i class="bi bi-geo-alt-fill"></i> {{ \App\Models\Pengaturan::ambil('alamat', 'Jl. Raya Pakusari No. 45, Pakusari - Jember') }}</span>
            <span><i class="bi bi-telephone-fill"></i> {{ \App\Models\Pengaturan::ambil('telepon', '(0331) 593XXX') }}</span>
            <span><i class="bi bi-envelope-fill"></i> {{ \App\Models\Pengaturan::ambil('email', 'smksibp@gmail.com') }}</span>
        </div>
        <div class="topbar__sosmed">
            <a href="#" aria-label="Facebook"><i class="bi bi-facebook"></i></a>
            <a href="#" aria-label="Instagram"><i class="bi bi-instagram"></i></a>
            <a href="#" aria-label="YouTube"><i class="bi bi-youtube"></i></a>
        </div>
    </div>
</div>

{{-- Navbar --}}
<header class="navbar">
    <div class="container navbar__inner">
        <a href="{{ route('beranda') }}" class="brand">
            <img src="{{ asset('images/logo.png') }}" alt="Logo" class="brand__logo" onerror="this.style.display='none'">
            <span class="brand__text">
                <strong>SMKS ISLAM<br>BUSTANUL ULUM</strong>
                <small>PAKUSARI - JEMBER</small>
            </span>
        </a>

        <button class="navbar__toggle" onclick="document.getElementById('menu').classList.toggle('open')" aria-label="Menu">
            <i class="bi bi-list"></i>
        </button>

        <nav id="menu" class="menu">
            <a href="{{ route('beranda') }}" class="{{ request()->routeIs('beranda') ? 'active' : '' }}">Beranda</a>
            <a href="{{ route('profil') }}">Profil <i class="bi bi-chevron-down"></i></a>
            <a href="{{ route('akademik') }}">Akademik <i class="bi bi-chevron-down"></i></a>
            <a href="{{ route('kesiswaan') }}">Kesiswaan <i class="bi bi-chevron-down"></i></a>
            <a href="{{ route('berita') }}">Berita <i class="bi bi-chevron-down"></i></a>
            <a href="{{ route('galeri') }}">Galeri</a>
            <a href="{{ route('ppdb') }}">PPDB</a>
        </nav>

        <div class="navbar__aksi">
            <button class="btn-cari" aria-label="Cari"><i class="bi bi-search"></i></button>
            @auth
                <a href="{{ route('admin.dashboard') }}" class="btn btn--primary"><strong>Admin</strong> <i class="bi bi-person-fill"></i></a>
            @else
                <a href="{{ route('login') }}" class="btn btn--primary"><strong>Login</strong> <i class="bi bi-person-fill"></i></a>
            @endauth
        </div>
    </div>
</header>

<main>
    @yield('content')
</main>

{{-- Footer --}}
<footer class="footer">
    <div class="container footer__grid">
        <div>
            <a href="{{ route('beranda') }}" class="brand brand--light">
                <img src="{{ asset('images/logo.png') }}" alt="Logo" class="brand__logo" onerror="this.style.display='none'">
                <span class="brand__text"><strong>SMKS ISLAM<br>BUSTANUL ULUM</strong><small>PAKUSARI - JEMBER</small></span>
            </a>
            <p class="footer__desc">SMKS Islam Bustanul Ulum Jember berkomitmen mencetak lulusan yang kompeten, berakhlak mulia, dan siap kerja.</p>
        </div>
        <div>
            <h4>Tautan Cepat</h4>
            <div class="footer__links">
                <a href="{{ route('beranda') }}">Beranda</a><a href="{{ route('berita') }}">Berita</a>
                <a href="{{ route('profil') }}">Profil Sekolah</a><a href="{{ route('galeri') }}">Galeri</a>
                <a href="{{ route('akademik') }}">Akademik</a><a href="{{ route('ppdb') }}">PPDB</a>
                <a href="{{ route('kesiswaan') }}">Kesiswaan</a>
            </div>
        </div>
        <div>
            <h4>Kontak Kami</h4>
            <ul class="footer__kontak">
                <li><i class="bi bi-geo-alt-fill"></i> {{ \App\Models\Pengaturan::ambil('alamat', 'Jl. Raya Pakusari No. 45, Pakusari - Jember') }}</li>
                <li><i class="bi bi-telephone-fill"></i> {{ \App\Models\Pengaturan::ambil('telepon', '(0331) 593XXX') }}</li>
                <li><i class="bi bi-envelope-fill"></i> {{ \App\Models\Pengaturan::ambil('email', 'smksibp@gmail.com') }}</li>
            </ul>
        </div>
        <div>
            <h4>Ikuti Kami</h4>
            <div class="footer__sosmed">
                <a href="#"><i class="bi bi-facebook"></i></a>
                <a href="#"><i class="bi bi-instagram"></i></a>
                <a href="#"><i class="bi bi-youtube"></i></a>
            </div>
        </div>
        <a href="{{ route('ppdb') }}" class="footer__ppdb">
            <i class="bi bi-laptop"></i>
            <span><strong>PPDB Online</strong><small>Daftar sekarang untuk masa depanmu</small></span>
            <i class="bi bi-arrow-right"></i>
        </a>
    </div>
    <div class="footer__bawah">
        <div class="container">
            <span>© {{ date('Y') }} SMKS Islam Bustanul Ulum Pakusari Jember. All rights reserved.</span>
            <span class="footer__bawah-nav"><a href="{{ route('beranda') }}">Beranda</a> | <a href="{{ route('profil') }}">Profil</a> | <a href="#">Kontak</a> | <a href="#">Sitemap</a></span>
        </div>
    </div>
</footer>

</body>
</html>
