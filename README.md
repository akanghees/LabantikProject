# Labantik

Landing page publik Labantik dibangun dengan Laravel dan Blade. Aset landing disimpan langsung di `public/assets/landing`, jadi halaman publik tidak memerlukan build Vite/npm.

## Persyaratan

- PHP 8.3 atau lebih baru
- Composer
- Database yang dikonfigurasi untuk Laravel (SQLite didukung)

## Menjalankan aplikasi

```bash
composer install
```

Salin `.env.example` menjadi `.env`, sesuaikan konfigurasi database, lalu jalankan:

```bash
php artisan key:generate
php artisan migrate
php artisan db:seed --class=SettingSeeder
php artisan storage:link
php artisan serve
```

Buka alamat yang ditampilkan oleh `php artisan serve`. Gambar dan berkas yang diunggah harus berada di disk `public`; tautan `public/storage` membuatnya dapat diakses melalui web. Konten setting awal diisi oleh `SettingSeeder` dan dapat diedit dari tabel `settings`.

## Halaman publik

- `/` — landing page: dokumentasi terbaru, galeri, divisi, struktur organisasi, prestasi, produk, testimoni, dan kontak.
- `/dokumentasi` — daftar dokumentasi dengan pencarian dan filter kategori.
- `/dokumentasi/{slug}` — detail dokumentasi.
- `/dokumentasi/{slug}/unduh` — mencatat unduhan lalu mengarahkan pengunjung ke URL unduh.
- `/struktur/{generation}` — kartu anggota untuk angkatan yang dipilih.

Setting seperti nama situs, teks hero, gambar, kontak, dan tautan sosial berasal dari `settings`. Jika nilainya belum tersedia, halaman menggunakan nilai bawaan di `App\Models\Setting`.

## Pengujian

```bash
php artisan test
```
