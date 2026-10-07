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
            'stat_siswa' => ['Jumlah siswa aktif', 'text'],
            'stat_guru' => ['Jumlah guru & staff', 'text'],
            'stat_prestasi' => ['Jumlah prestasi (mis. 120+)', 'text'],
            'alamat' => ['Alamat sekolah', 'text'],
            'telepon' => ['Telepon', 'text'],
            'email' => ['Email sekolah', 'text'],
            'tentang' => ['Teks "Tentang Kami" di beranda', 'textarea'],
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
        $request->validate(array_fill_keys(array_keys($this->daftar()), 'nullable|string|max:2000'));

        foreach (array_keys($this->daftar()) as $kunci) {
            Pengaturan::simpan($kunci, $request->input($kunci));
        }

        return back()->with('ok', 'Pengaturan situs disimpan.');
    }
}
