<section class="kepala-hal">
    <div class="container">
        <small><a href="{{ route('beranda') }}">Beranda</a> <i class="bi bi-chevron-right"></i> {{ $judul }}</small>
        <h1>{{ $judul }}</h1>
        @isset($sub)<p>{{ $sub }}</p>@endisset
    </div>
</section>
