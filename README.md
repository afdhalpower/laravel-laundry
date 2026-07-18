<div align="center">
  <br>
  <h1>🧺 LaundryKu</h1>
  <p><strong>Aplikasi Manajemen Laundry</strong> — berbasis Laravel 11, dirancang untuk usaha laundry kecil & menengah.</p>
  <p>
    <img src="https://img.shields.io/badge/Laravel-11-FF2D20?logo=laravel" alt="Laravel 11">
    <img src="https://img.shields.io/badge/PHP-8.3-777BB4?logo=php" alt="PHP 8.3">
    <img src="https://img.shields.io/badge/SQLite-003B57?logo=sqlite" alt="SQLite">
    <img src="https://img.shields.io/badge/Bootstrap-5-7952B3?logo=bootstrap" alt="Bootstrap 5">
    <img src="https://img.shields.io/badge/license-MIT-blue" alt="MIT License">
  </p>
  <br>
</div>

## 📋 Daftar Isi

- [Fitur](#-fitur)
- [Prasyarat](#-prasyarat)
- [Instalasi](#-instalasi)
- [Login Default](#-login-default)
- [Deployment](#-deployment-ke-shared-hosting)
- [Struktur Database](#-struktur-database)
- [Tampilan](#-tampilan)
- [Tech Stack](#-tech-stack)
- [Lisensi](#-lisensi)

---

## ✨ Fitur

| Fitur | Keterangan |
|-------|------------|
| 👥 **Manajemen Pelanggan** | CRUD pelanggan, **detail + riwayat transaksi**, sistem **Loyalty Points** (earn & redeem) |
| 🛠️ **Layanan Laundry** | Kelola layanan kiloan & satuan, manajemen **Paket Laundry** |
| 📋 **Transaksi / Order** | Buat order, pilih layanan, tracking status, **auto-lock saat selesai**, **cetak barcode label** |
| 🔄 **Status Tracking** | Alur: Diterima → Dicuci → Dikeringkan → Disetrika → Dilipat → Siap → Diantar → Selesai |
| 🔍 **Cek Status Publik** | Pelanggan cek status pakaian via **landing page** dengan nomor order |
| 💰 **Pembayaran** | Catat pembayaran, histori cicilan, edit/hapus pembayaran, **laporan laba-rugi** |
| 🗑️ **Trash & Restore** | Order yang dihapus masuk ke **Trash**, bisa direstore |
| 📊 **Export Excel** | Laporan transaksi bisa di-export ke **format .xlsx** |
| 📝 **Activity Log** | Tracking semua perubahan data untuk keamanan & audit |
| ⚙️ **Multi-Role** | Akses dibatasi: Admin (full), Kasir (transaksi), Owner (laporan) |
| 🌗 **Dark Mode** | Toggle tema terang/gelap yang persisten |
| 🛡️ **Stability & Safety** | **Double submission prevention**, **Order lifecycle lock** (status selesai tidak bisa diubah), **Backup database command** |

---

## 🚀 Prasyarat

- **PHP** 8.1 atau lebih baru
- **Composer** 2.x
- **Database** SQLite (pengembangan) / MySQL 5.7+ (produksi)
- **Ekstensi PHP**: `bcmath`, `ctype`, `fileinfo`, `json`, `mbstring`, `openssl`, `pdo`, `tokenium`, `xml`

---

## 🛠️ Instalasi

```bash
# 1. Clone repositori
git clone https://github.com/afdhalpower/laravel-laundry.git
cd laravel-laundry

# 2. Install dependency PHP
composer install --no-dev --optimize-autoloader

# 3. Copy environment
cp .env.example .env
php artisan key:generate

# 4. Setup database (SQLite — default untuk development)
touch database/database.sqlite

# 5. Migrasi & seed data awal
php artisan migrate --seed

# 6. Buat symbolic link storage
php artisan storage:link

# 7. Jalankan development server
php artisan serve
```

Akses di **http://localhost:8000**

---

## 🔐 Login Default

| Role | Email | Password |
|------|-------|----------|
| Admin | `admin@laundryku.com` | `password` |
| Kasir | `kasir@laundryku.com` | `password` |
| Owner | `owner@laundryku.com` | `password` |

---

## 🏗️ Deployment ke Shared Hosting

| Langkah | Detail |
|---------|--------|
| **1. Upload** | Upload semua file ke hosting |
| **2. Document Root** | Arahkan ke folder `public/` |
| **3. Database** | Buat database MySQL via cPanel |
| **4. Environment** | Edit `.env` — ganti `sqlite` → `mysql`, isi kredensial DB |
| **5. Migrasi** | Jalankan `php artisan migrate --seed` |
| **6. Permission** | Set `storage/` dan `bootstrap/cache/` ke `755` |

---

## 🗂️ Struktur Database

```
users, customers, orders, order_items, services, payments, expenses, packages, loyalty_points, activity_logs
```

---

## 🎨 Tampilan

- **Admin Panel**: Bootstrap 5.3, sidebar navy, **Dark Mode ready**.
- **Fitur Baru**: Laporan Laba-Rugi (Chart.js), Detail Pelanggan, Trash, Activity Log.
- **Tools**: Barcode generator (Milon), Excel Export (Maatwebsite).

---

## 🛠️ Tech Stack

- **Backend**: Laravel 11, PHP 8.3
- **Database**: SQLite (dev) / MySQL (prod)
- **Frontend**: Bootstrap 5.3, Chart.js, Bootstrap Icons
- **Packages**: maatwebsite/excel, milon/barcode

---

## 📄 Lisensi

**MIT License** — © 2026 [afdhalpower](https://github.com/afdhalpower)
