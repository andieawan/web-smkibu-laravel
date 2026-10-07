<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Pengaturan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class PengaturanController extends Controller
{
    /** @return array<string, array<string, array{0:string,1:string,2:string}>> grup => kunci => [label, tipe, aturan] */
    private function grup(): array
    {
        return [
            'Umum' => [
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
            ],
            'Halaman Profil (bagian yang dikosongkan tidak ditampilkan)' => [
                'profil_kepsek' => ['Nama Kepala Sekolah', 'text', 'nullable|string|max:100'],
                'profil_sambutan' => ['Sambutan Kepala Sekolah', 'textarea', 'nullable|string|max:5000'],
                'profil_sejarah' => ['Sejarah singkat sekolah', 'textarea', 'nullable|string|max:5000'],
                'profil_visi' => ['Visi', 'textarea', 'nullable|string|max:1000'],
                'profil_misi' => ['Misi (satu butir per baris)', 'textarea', 'nullable|string|max:3000'],
                'profil_npsn' => ['NPSN', 'text', 'nullable|string|max:20'],
                'profil_akreditasi' => ['Akreditasi (mis. A)', 'text', 'nullable|string|max:20'],
                'profil_tahun' => ['Tahun berdiri', 'text', 'nullable|string|max:10'],
            ],
            'Halaman Akademik' => [
                'akademik_kurikulum' => ['Kurikulum yang digunakan', 'textarea', 'nullable|string|max:3000'],
                'akademik_jam' => ['Jam belajar (satu baris per hari/keterangan, mis. "Senin - Kamis: 07.00 - 15.00")', 'textarea', 'nullable|string|max:1000'],
                'akademik_pkl' => ['Praktik Kerja Lapangan & kerja sama industri', 'textarea', 'nullable|string|max:3000'],
            ],
            'Halaman Kesiswaan' => [
                'kesiswaan_osis' => ['Tentang OSIS & pembinaan siswa', 'textarea', 'nullable|string|max:3000'],
                'kesiswaan_tatatertib' => ['Tata tertib singkat (satu butir per baris)', 'textarea', 'nullable|string|max:3000'],
                'kesiswaan_beasiswa' => ['Beasiswa & bantuan siswa', 'textarea', 'nullable|string|max:3000'],
            ],
        ];
    }

    private function daftar(): array
    {
        return array_merge(...array_values($this->grup()));
    }

    public function edit()
    {
        $grup = $this->grup();
        $nilai = Pengaturan::pluck('nilai', 'kunci')->all();

        return view('admin.pengaturan', compact('grup', 'nilai'));
    }

    public function update(Request $request)
    {
        $request->validate(array_map(fn ($d) => $d[2], $this->daftar()) + [
            'logo' => 'nullable|image|mimes:png,jpg,jpeg,webp|max:2048',
        ]);

        foreach (array_keys($this->daftar()) as $kunci) {
            Pengaturan::simpan($kunci, $request->input($kunci));
        }

        $this->simpanLogo($request);

        return back()->with('ok', 'Pengaturan situs disimpan.');
    }

    /** Logo baru menggantikan yang lama; kotak "hapus" mengembalikan ke berkas bawaan. */
    private function simpanLogo(Request $request): void
    {
        $lama = Pengaturan::ambil('logo');

        if ($request->hasFile('logo')) {
            $berkas = $request->file('logo');
            $nama = 'konten/logo-' . Str::random(20) . '.' . $berkas->extension();
            Storage::disk('public')->put($nama, file_get_contents($berkas->getRealPath()));
            Pengaturan::simpan('logo', $nama);
        } elseif ($request->boolean('hapus_logo') && $lama) {
            Pengaturan::simpan('logo', null);
        } else {
            return;
        }

        if ($lama) {
            Storage::disk('public')->delete($lama);
        }
    }
}
