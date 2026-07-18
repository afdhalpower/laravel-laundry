<div align="center">
  <h1>🧺 LaundryKu</h1>
  <p>Aplikasi Manajemen Laundry berbasis Laravel — simple, cepat, dan siap shared hosting.</p>
</div>

## ✨ Fitur

| Fitur | Keterangan |
|-------|------------|
| 👥 **Manajemen Pelanggan** | Tambah, edit, hapus, cari pelanggan |
| 🛠️ **Layanan Laundry** | Kelola layanan kiloan & satuan dengan harga |
| 📋 **Transaksi / Order** | Buat order, pilih layanan, tracking status |
| 🔄 **Status Tracking** | Diterima → Dicuci → Dikeringkan → Disetrika → Dilipat → Siap → Diantar → Selesai |
| 💰 **Pembayaran** | Catat pembayaran, histori, status lunas |
| 🖨️ **Invoice** | Cetak struk invoice (thermal printer ready) |
| 📊 **Dashboard** | Statistik real-time, grafik 7 hari |
| 📈 **Laporan** | Filter tanggal, grafik pendapatan, detail transaksi |

## 🚀 Instalasi

### Prasyarat

- PHP 8.1+
- Composer
- SQLite (dev) / MySQL (production)

### Langkah Instalasi

```bash
# Clone repositori
git clone https://github.com/afdhalpower/laravel-laundry.git
cd laravel-laundry

# Install dependencies
composer install --no-dev --optimize-autoloader

# Copy & setup environment
cp .env.example .env
php artisan key:generate

# Setup database (SQLite default)
touch database/database.sqlite

# Migrate & seed
php artisan migrate --seed

# Setup storage
php artisan storage:link

# Jalankan
php artisan serve
```

### Login Default

| Role | Email | Password |
|------|-------|----------|
| Admin | `admin@laundry.test` | `password` |

## 🏗️ Deployment ke Shared Hosting

1. **Upload semua file** ke hosting (kecuali folder `storage` bawaan)
2. **Set Document Root** ke folder `public/`
3. **Buat database MySQL** lewat phpMyAdmin / cPanel
4. **Edit `.env`**: ganti `DB_CONNECTION=sqlite` → `mysql` dan isi kredensial
5. **Jalankan** `php artisan migrate --seed` via SSH/Terminal
6. Set **permission** folder `storage/` dan `bootstrap/cache/` ke `755`

## 🗂️ Struktur Database

```
customers → orders → order_items → services
                    → payments
```

## 🎨 Tampilan

- **Sidebar**: Navigasi fixed di kiri dengan background gradasi navy
- **Dashboard**: 4 kartu statistik + grafik Chart.js + order terbaru
- **Desain**: Bootstrap 5, Inter font, mobile responsive
- **Bahasa**: Indonesia (UI sepenuhnya dalam Bahasa Indonesia)

## 🛠️ Tech Stack

- **Backend**: Laravel 11, PHP 8.3
- **Database**: SQLite (dev) / MySQL (production)
- **Frontend**: Bootstrap 5, Chart.js, Bootstrap Icons
- **Auth**: Laravel Breeze (Blade)

## 📄 Lisensi

MIT — afdhalpower
