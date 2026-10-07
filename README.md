# Website SMKS Islam Bustanul Ulum (Laravel + MySQL + Admin)

Butuh: PHP 8.2+, Composer, MySQL.

## 1. Buat proyek & database
```bash
composer create-project laravel/laravel smk-ibu
cd smk-ibu
```
Buat database kosong di MySQL, mis. `smk_ibu`. Lalu edit `.env`:
```
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=smk_ibu
DB_USERNAME=root
DB_PASSWORD=

APP_LOCALE=id
APP_URL=http://127.0.0.1:8000
```

## 2. Salin file
Salin seluruh isi folder `smk-ibu-overlay` ke proyek (timpa file yang sama):
routes/, app/, database/, resources/views/, public/css/.

## 3. Jalankan
```bash
php artisan migrate --seed
php artisan storage:link
php artisan serve
```
- Website : http://127.0.0.1:8000
- Admin   : http://127.0.0.1:8000/login
  - email `admin@smkibu.sch.id`, password `admin12345`
  - **GANTI password segera** (ubah di database/seeder sebelum `--seed`, atau lewat `php artisan tinker`).

## Gambar tetap (taruh di public/images/)
logo.png, hero.jpg, gedung.jpg. Foto berita & galeri diunggah lewat panel admin
(tersimpan di storage/app/public/konten, butuh `storage:link`).

## Yang bisa dikelola admin
Berita, Pengumuman, Agenda, Galeri, Program Keahlian, dan Pengaturan Situs
(angka statistik, alamat, telepon, email, teks "Tentang Kami").

## Belum dibuat
Halaman Profil, Akademik, Kesiswaan, PPDB (masih placeholder), banner hero yang bisa diganti dari admin.

## Catatan repo
Repo ini berisi **overlay** (file yang ditimpa ke proyek Laravel baru), bukan proyek Laravel lengkap.
Ikuti langkah di atas untuk memasangnya.
