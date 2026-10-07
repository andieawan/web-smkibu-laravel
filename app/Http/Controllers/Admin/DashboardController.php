<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Agenda;
use App\Models\Berita;
use App\Models\Ekstrakurikuler;
use App\Models\Galeri;
use App\Models\Pengumuman;
use App\Models\ProgramKeahlian;
use App\Models\Slide;
use App\Models\Staf;

class DashboardController extends Controller
{
    public function index()
    {
        return view('admin.dashboard', [
            'ringkasan' => [
                ['Berita', Berita::count(), 'admin.berita.index', 'bi-newspaper'],
                ['Pengumuman', Pengumuman::count(), 'admin.pengumuman.index', 'bi-megaphone-fill'],
                ['Agenda', Agenda::count(), 'admin.agenda.index', 'bi-calendar-week-fill'],
                ['Foto Galeri', Galeri::count(), 'admin.galeri.index', 'bi-camera-fill'],
                ['Program Keahlian', ProgramKeahlian::count(), 'admin.program.index', 'bi-mortarboard-fill'],
                ['Ekstrakurikuler', Ekstrakurikuler::count(), 'admin.ekstrakurikuler.index', 'bi-people-fill'],
                ['Guru & Staf', Staf::count(), 'admin.staf.index', 'bi-person-badge-fill'],
                ['Banner Hero', Slide::count(), 'admin.slide.index', 'bi-images'],
            ],
        ]);
    }
}
