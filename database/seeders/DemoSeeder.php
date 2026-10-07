<?php

namespace Database\Seeders;

use App\Models\Agenda;
use App\Models\Berita;
use App\Models\Pengaturan;
use App\Models\Pengumuman;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

/**
 * Data CONTOH untuk pengembangan/demo (jangan dijalankan di server produksi):
 *     php artisan db:seed --class=DemoSeeder
 * Tanggal dibuat relatif terhadap hari ini.
 */
class DemoSeeder extends Seeder
{
    public function run(): void
    {
        foreach (['stat_siswa' => '682', 'stat_guru' => '48', 'stat_prestasi' => '120+'] as $k => $v) {
            Pengaturan::simpan($k, $v);
        }

        if (Berita::count() === 0) {
            foreach ([
                ['SMKS Islam Bustanul Ulum Gelar Halal bi Halal dan Silaturahmi', 'Kegiatan', 3, 'Keluarga besar SMKS Islam Bustanul Ulum Pakusari Jember menggelar kegiatan Halal bi Halal untuk mempererat tali silaturahmi antara guru, karyawan, dan siswa.'],
                ['Siswa SMKS Islam Bustanul Ulum Raih Juara 2 LKS Tingkat Kabupaten', 'Prestasi', 10, 'Alhamdulillah, siswa kami berhasil meraih Juara 2 dalam Lomba Kompetensi Siswa (LKS) Tingkat Kabupaten Jember pada bidang Teknik Komputer dan Jaringan.'],
                ['Pembukaan Pendaftaran PPDB Tahun Ajaran Baru', 'Informasi', 17, 'Pendaftaran peserta didik baru (PPDB) SMKS Islam Bustanul Ulum Pakusari Jember telah dibuka. Segera daftarkan diri Anda dan jadi bagian dari keluarga besar kami.'],
            ] as [$judul, $kategori, $hariLalu, $ringkas]) {
                Berita::create([
                    'judul' => $judul, 'slug' => Str::slug($judul) . '-' . Str::lower(Str::random(4)),
                    'kategori' => $kategori, 'tanggal' => now()->subDays($hariLalu)->toDateString(),
                    'ringkas' => $ringkas, 'isi' => $ringkas, 'terbit' => true,
                ]);
            }
        }

        if (Pengumuman::count() === 0) {
            foreach ([
                ['Jadwal Ujian Tengah Semester', 'Akademik', 5],
                ['Libur Hari Raya', 'Kesiswaan', 12],
                ['Pengumuman Kelulusan Kelas XII', 'Akademik', 20],
                ['Pembagian Raport Semester', 'Akademik', 26],
            ] as [$judul, $kategori, $hariLalu]) {
                Pengumuman::create(['judul' => $judul, 'kategori' => $kategori, 'tanggal' => now()->subDays($hariLalu)->toDateString()]);
            }
        }

        if (Agenda::count() === 0) {
            foreach ([
                ['Ujian Praktik Kejuruan (UPK)', 3, '07.00 - Selesai'],
                ['Rapat Wali Murid', 8, '09.00 - 12.00'],
                ['Peringatan Hari Besar Nasional', 14, '08.00 - Selesai'],
                ['Pesantren Kilat', 21, '08.00 - 15.00'],
            ] as [$judul, $hariLagi, $waktu]) {
                Agenda::create(['judul' => $judul, 'tanggal' => now()->addDays($hariLagi)->toDateString(), 'waktu' => $waktu]);
            }
        }
    }
}
