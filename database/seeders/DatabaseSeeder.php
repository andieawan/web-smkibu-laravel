<?php

namespace Database\Seeders;

use App\Models\Agenda;
use App\Models\Berita;
use App\Models\Pengaturan;
use App\Models\Pengumuman;
use App\Models\ProgramKeahlian;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Admin awal. GANTI password ini segera setelah login pertama.
        User::firstOrCreate(
            ['email' => 'admin@smkibu.sch.id'],
            ['name' => 'Administrator', 'password' => Hash::make('admin12345')]
        );

        $pengaturan = [
            'stat_siswa' => '682', 'stat_guru' => '48', 'stat_prestasi' => '120+',
            'alamat' => 'Jl. Raya Pakusari No. 45, Pakusari - Jember',
            'telepon' => '(0331) 593XXX', 'email' => 'smksibp@gmail.com',
            'tentang' => 'SMKS Islam Bustanul Ulum Pakusari Jember adalah sekolah menengah kejuruan yang berlandaskan nilai-nilai Islam dan berkomitmen untuk mencetak lulusan yang kompeten, berakhlak mulia, serta siap menghadapi dunia kerja dan melanjutkan pendidikan ke jenjang yang lebih tinggi.',
        ];
        foreach ($pengaturan as $k => $v) {
            Pengaturan::firstOrCreate(['kunci' => $k], ['nilai' => $v]);
        }

        if (ProgramKeahlian::count() === 0) {
            foreach ([
                ['Teknik Komputer dan Jaringan (TKJ)', 'bi-pc-display'],
                ['Multimedia (MM)', 'bi-code-square'],
                ['Akuntansi (AK)', 'bi-calculator'],
                ['Otomatisasi Tata Kelola Perkantoran (OTKP)', 'bi-file-earmark-text'],
                ['Rekayasa Perangkat Lunak (RPL)', 'bi-code-slash'],
            ] as $i => [$nama, $ikon]) {
                ProgramKeahlian::create(['nama' => $nama, 'ikon' => $ikon, 'urutan' => $i + 1]);
            }
        }

        if (Berita::count() === 0) {
            foreach ([
                ['SMKS Islam Bustanul Ulum Gelar Halal bi Halal dan Silaturahmi', 'Kegiatan', '2025-04-26', 'Keluarga besar SMKS Islam Bustanul Ulum Pakusari Jember menggelar kegiatan Halal bi Halal rangka mempererat tali silaturahmi antara guru, karyawan, dan siswa.'],
                ['Siswa SMKS Islam Bustanul Ulum Raih Juara 2 LKS Tingkat Kabupaten', 'Prestasi', '2025-04-24', 'Alhamdulillah, siswa kami berhasil meraih Juara 2 dalam Lomba Kompetensi Siswa (LKS) Tingkat Kabupaten Jember pada bidang Teknik Komputer dan Jaringan.'],
                ['Pembukaan Pendaftaran PPDB Tahun Ajaran 2025/2026', 'Informasi', '2025-04-18', 'Pendaftaran peserta didik baru (PPDB) SMKS Islam Bustanul Ulum Pakusari Jember telah dibuka. Segera daftarkan diri Anda dan jadi bagian dari keluarga besar kami.'],
            ] as [$judul, $kat, $tgl, $ringkas]) {
                Berita::create([
                    'judul' => $judul, 'slug' => Str::slug($judul) . '-' . Str::lower(Str::random(4)),
                    'kategori' => $kat, 'tanggal' => $tgl, 'ringkas' => $ringkas, 'isi' => $ringkas, 'terbit' => true,
                ]);
            }
        }

        if (Pengumuman::count() === 0) {
            foreach ([
                ['Jadwal Ujian Tengah Semester Genap Tahun Ajaran 2024/2025', 'Akademik', '2025-05-03'],
                ['Libur Hari Raya Idul Fitri 1446 H', 'Kesiswaan', '2025-04-30'],
                ['Pengumuman Kelulusan Kelas XII Tahun 2024/2025', 'Akademik', '2025-04-25'],
                ['Pembagian Raport Semester Genap Tahun 2024/2025', 'Akademik', '2025-04-20'],
            ] as [$judul, $kat, $tgl]) {
                Pengumuman::create(['judul' => $judul, 'kategori' => $kat, 'tanggal' => $tgl]);
            }
        }

        if (Agenda::count() === 0) {
            foreach ([
                ['Ujian Praktik Kejuruan (UPK)', '2025-05-10', '07.00 - Selesai'],
                ['Rapat Wali Murid', '2025-05-15', '09.00 - 12.00'],
                ['Peringatan Hari Kebangkitan Nasional', '2025-05-20', '08.00 - Selesai'],
                ['Pesantren Kilat Ramadhan', '2025-05-25', '08.00 - 15.00'],
            ] as [$judul, $tgl, $waktu]) {
                Agenda::create(['judul' => $judul, 'tanggal' => $tgl, 'waktu' => $waktu]);
            }
        }
    }
}
