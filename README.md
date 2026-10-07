# Website SMKS Islam Bustanul Ulum Pakusari - Jember

Laravel 13 + MySQL. Beranda, berita, galeri, dan panel admin (berita, pengumuman, agenda,
galeri, program keahlian, pengaturan situs).

Butuh: **PHP 8.3+** (ext: mbstring, xml, curl, zip, mysql/pdo_mysql, gd, bcmath, intl, fileinfo), Composer 2, MySQL/MariaDB.
Node.js **tidak diperlukan** (tidak ada build frontend).

## Instalasi (VM / server)

```bash
git clone https://github.com/andieawan/web-smkibu-laravel.git
cd web-smkibu-laravel

composer install --no-dev --optimize-autoloader
cp .env.example .env
php artisan key:generate
```

Buat database dan user MySQL:

```sql
CREATE DATABASE smk_ibu CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
CREATE USER 'smk_ibu'@'localhost' IDENTIFIED BY 'GANTI_PASSWORD_KUAT';
GRANT ALL PRIVILEGES ON smk_ibu.* TO 'smk_ibu'@'localhost';
FLUSH PRIVILEGES;
```

Edit `.env`: isi `DB_PASSWORD`, set `APP_URL` ke alamat sebenarnya, dan untuk produksi
`APP_ENV=production`, `APP_DEBUG=false`. Lalu:

```bash
php artisan migrate --seed --force
php artisan storage:link
php artisan config:cache && php artisan route:cache && php artisan view:cache
```

Izin folder (user web server, mis. `www-data`):

```bash
sudo chown -R www-data:www-data storage bootstrap/cache
sudo chmod -R ug+rw storage bootstrap/cache
```

## Web server

Arahkan *document root* ke folder `public/`. Contoh Nginx:

```nginx
server {
    listen 80;
    server_name smkibu.example.sch.id;
    root /var/www/web-smkibu-laravel/public;
    index index.php;
    client_max_body_size 4M;

    location / { try_files $uri $uri/ /index.php?$query_string; }
    location ~ \.php$ {
        include snippets/fastcgi-php.conf;
        fastcgi_pass unix:/run/php/php8.3-fpm.sock;
    }
    location ~ /\.(?!well-known).* { deny all; }
}
```

(Apache: aktifkan `mod_rewrite`; `public/.htaccess` sudah ada.)

## Admin

- Login: `/login`
- Akun awal dari seeder: `admin@smkibu.sch.id` / `admin12345`
- **Ganti password ini segera** setelah instalasi pertama, mis.:
  ```bash
  php artisan tinker
  >>> App\Models\User::first()->update(['password' => 'PASSWORD_BARU_YANG_KUAT']);
  ```
  (password di-hash otomatis oleh model.)

## Gambar

> `APP_URL` di `.env` harus sama dengan alamat yang dipakai membuka website (URL foto dibuat dari nilai ini).

Taruh di `public/images/`: `logo.png`, `hero.jpg`, `gedung.jpg`.
Foto berita dan galeri diunggah dari panel admin (disimpan di `storage/app/public/konten`).

## Pengembangan lokal

```bash
composer install
cp .env.example .env && php artisan key:generate
php artisan migrate --seed
php artisan serve
php artisan test      # tes memakai SQLite in-memory
```

## Update di server

```bash
git pull
composer install --no-dev --optimize-autoloader
php artisan migrate --force
php artisan config:cache && php artisan route:cache && php artisan view:cache
```

## Belum dibuat

Halaman Profil, Akademik, Kesiswaan, PPDB (masih placeholder) dan banner hero yang bisa diganti dari admin.
