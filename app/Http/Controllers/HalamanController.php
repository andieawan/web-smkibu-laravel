<?php

namespace App\Http\Controllers;

use App\Models\Berita;
use App\Models\Galeri;

/** Halaman publik yang datanya dari database. */
class HalamanController extends Controller
{
    public function berita()
    {
        return view('berita.index', [
            'berita' => Berita::where('terbit', true)->orderByDesc('tanggal')->paginate(9),
        ]);
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
