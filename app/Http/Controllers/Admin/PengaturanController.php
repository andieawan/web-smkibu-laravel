<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Pengaturan;
use Illuminate\Http\Request;

class PengaturanController extends Controller
{
    private function daftar(): array
    {
        return [
            'stat_siswa' => ['Jumlah siswa aktif', 'text', 'nullable|string|max:20'],
            'stat_guru' => ['Jumlah guru & staff', 'text', 'nullable|string|max:20'],
            'stat_prestasi' => ['Jumlah prestasi (mis. 120+)', 'text', 'nullable|string|max:20'],
            'alamat' => ['Alamat sekolah', 'text', 'nullable|string|max:255'],
            'telepon' => ['Telepon', 'text', 'nullable|string|max:50'],
            'email' => ['Email sekolah', 'text', 'nullable|email|max:255'],
            'sosmed_facebook' => ['Link Facebook (kosongkan untuk menyembunyikan)', 'text', 'nullable|url:http,https|max:255'],
            'sosmed_instagram' => ['Link Instagram', 'text', 'nullable|url:http,https|max:255'],
            'sosmed_youtube' => ['Link YouTube', 'text', 'nullable|url:http,https|max:255'],
            'tentang' => ['Teks "Tentang Kami" di beranda', 'textarea', 'nullable|string|max:2000'],
        ];
    }

    public function edit()
    {
        $daftar = $this->daftar();
        $nilai = Pengaturan::pluck('nilai', 'kunci')->all();

        return view('admin.pengaturan', compact('daftar', 'nilai'));
    }

    public function update(Request $request)
    {
        $request->validate(array_map(fn ($d) => $d[2], $this->daftar()));

        foreach (array_keys($this->daftar()) as $kunci) {
            Pengaturan::simpan($kunci, $request->input($kunci));
        }

        return back()->with('ok', 'Pengaturan situs disimpan.');
    }
}
