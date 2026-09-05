# Monitoring Progres

Aplikasi web untuk memantau progres fisik dan keuangan kegiatan pembangunan. Aplikasi ini menyediakan dashboard ringkasan, pengelolaan kegiatan, pencatatan progres, rekapitulasi, notifikasi, serta pengaturan akun pengguna.

## Fitur Utama

- Dashboard monitoring progres kegiatan.
- Manajemen data kegiatan.
- Pencatatan dan pembaruan progres fisik.
- Pencatatan dan pembaruan progres keuangan.
- Rekapitulasi progres kegiatan.
- Notifikasi untuk aktivitas kegiatan dan progres.
- Autentikasi, verifikasi email, reset password, dan logout.
- Profil pengguna untuk mengubah nama serta email.
- Pengaturan akun untuk mengubah password dan menghapus akun.
- Halaman login dengan branding PUPR dan layout dashboard yang responsif.
- Kartu informasi admin di bagian bawah sidebar.
- Tampilan responsif dengan dukungan tema dashboard.

## Teknologi

- PHP 8.2+
- Laravel 12
- Laravel Breeze untuk alur autentikasi
- Bootstrap dan Bootstrap Icons untuk antarmuka dashboard
- Vite untuk asset frontend
- Pest dan PHPUnit untuk pengujian

## Persyaratan

Pastikan perangkat sudah memiliki:

- PHP 8.2 atau lebih baru
- Composer
- Node.js dan npm
- Database yang didukung Laravel, seperti MySQL, MariaDB, atau SQLite
- Ekstensi PHP database yang sesuai dengan koneksi yang digunakan

## Instalasi

1. Clone repository dan masuk ke folder proyek:

   ```bash
   git clone https://github.com/L0udbaa/website_pu.git
   cd website_pu
   ```

2. Install dependency PHP dan frontend:

   ```bash
   composer install
   npm install
   ```

3. Buat file environment dan generate application key:

   ```bash
   cp .env.example .env
   php artisan key:generate
   ```

4. Atur koneksi database pada file `.env`. Secara default aplikasi menggunakan SQLite:

   ```env
   DB_CONNECTION=sqlite
   DB_DATABASE=/absolute/path/ke/database/database.sqlite
   ```

   Pastikan file database tersedia sebelum menjalankan migration. Untuk MySQL, gunakan konfigurasi berikut:

   ```env
   DB_CONNECTION=mysql
   DB_HOST=127.0.0.1
   DB_PORT=3306
   DB_DATABASE=monitoring_progres
   DB_USERNAME=root
   DB_PASSWORD=
   ```

5. Jalankan migration dan seeder:

   ```bash
   php artisan migrate --seed
   ```

6. Build asset frontend:

   ```bash
   npm run build
   ```

## Menjalankan Aplikasi

Untuk menjalankan server Laravel:

```bash
php artisan serve
```

Aplikasi dapat dibuka melalui `http://127.0.0.1:8000`.

Selama pengembangan frontend, jalankan Vite pada terminal terpisah:

```bash
npm run dev
```

Alternatifnya, seluruh proses development dapat dijalankan dengan:

```bash
composer run dev
```

## Akun Development

Seeder menyediakan akun administrator berikut untuk kebutuhan development:

- Username: `admin`
- Email: `admin@gmail.com`
- Password: `admin123`

Ganti password akun tersebut pada lingkungan selain development.

## Route Utama

| Halaman | URL | Keterangan |
| --- | --- | --- |
| Dashboard | `/dashboard` | Ringkasan monitoring |
| Kegiatan | `/kegiatan` | Kelola data kegiatan |
| Progres fisik | `/progres-fisik` | Kelola progres fisik |
| Progres keuangan | `/progres-keuangan` | Kelola progres keuangan |
| Rekapitulasi | `/rekapitulasi` | Lihat rekap progres |
| Notifikasi | `/notifikasi` | Lihat notifikasi pengguna |
| Profil | `/profile` | Kelola nama dan email |
| Pengaturan akun | `/settings` | Kelola password dan keamanan akun |

Semua route aplikasi, kecuali halaman autentikasi dan redirect awal, membutuhkan pengguna yang sudah login. Dashboard juga membutuhkan email yang sudah diverifikasi.

## Autentikasi

Halaman login tersedia di `/login` dan menggunakan layout guest yang mengikuti template dashboard PUPR. Alur autentikasi juga mencakup:

- Registrasi pengguna.
- Verifikasi email.
- Reset password.
- Konfirmasi password.
- Logout.

Setelah login, pengguna dapat membuka profil melalui `/profile` atau pengaturan keamanan melalui `/settings`.

## Pengujian

Jalankan seluruh test dengan:

```bash
php artisan test
```

Untuk pengujian berbasis SQLite in-memory, pastikan ekstensi `pdo_sqlite` aktif pada instalasi PHP.

## Struktur Direktori Penting

```text
app/
  Http/Controllers/       Controller aplikasi dan autentikasi
  Http/Requests/          Validasi request
  Models/                 Model kegiatan dan progres
  Notifications/          Notifikasi aplikasi

database/
  migrations/             Struktur tabel database
  seeders/                Data awal development

resources/views/
  dashboard.blade.php     Halaman dashboard
  kegiatan/               Halaman kegiatan
  progres-fisik/          Halaman progres fisik
  progres-keuangan/       Halaman progres keuangan
  profile/                Halaman profil
  settings/               Pengaturan akun
  notifikasi/             Halaman notifikasi

public/assets/            Asset Bootstrap, icon, gambar, dan JavaScript
routes/                   Route web dan autentikasi
```

## Catatan Pengembangan

Gunakan `npm run dev` saat mengubah asset frontend dan `npm run build` sebelum deployment. Jangan menggunakan akun seed administrator pada lingkungan production tanpa mengganti passwordnya.

## Lisensi

Proyek ini menggunakan Laravel sebagai framework utama. Detail lisensi dan dependensi mengikuti konfigurasi pada `composer.json`.
