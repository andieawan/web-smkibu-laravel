<?php

namespace App\Http\Controllers;

use App\Models\Agenda;
use App\Models\Berita;
use App\Models\Galeri;
use App\Models\Pengumuman;

/** Halaman publik yang datanya dari database. */
class HalamanController extends Controller
{
    public function berita()
    {
        $q = trim((string) request('q', ''));

        $berita = Berita::where('terbit', true)
            ->when($q !== '', function ($query) use ($q) {
                // Karakter khusus LIKE di-escape supaya dicari apa adanya.
                $kata = '%' . str_replace(['\\', '%', '_'], ['\\\\', '\\%', '\\_'], $q) . '%';
                $query->where(fn ($w) => $w->where('judul', 'like', $kata)->orWhere('ringkas', 'like', $kata));
            })
            ->orderByDesc('tanggal')
            ->paginate(9)
            ->withQueryString();

        return view('berita.index', ['berita' => $berita, 'q' => $q]);
    }

    public function pengumuman()
    {
        return view('pengumuman', ['pengumuman' => Pengumuman::orderByDesc('tanggal')->paginate(15)]);
    }

    public function agenda()
    {
        return view('agenda', ['agenda' => Agenda::orderByDesc('tanggal')->paginate(15)]);
    }

    public function beritaShow(string $slug)
    {
        $berita = Berita::where('terbit', true)->where('slug', $slug)->firstOrFail();

        return view('berita.show', [
            'berita' => $berita,
            'lainnya' => Berita::where('terbit', true)->where('id', '!=', $berita->id)->orderByDesc('tanggal')->take(4)->get(),
        ]);
    }

    public function galeri()
    {
        return view('galeri', [
            'galeri' => Galeri::orderByDesc('tanggal')->paginate(12),
        ]);
    }
}
