<div align="center">
  <br>
  <h1>🧺 LaundryKu</h1>
  <p><strong>Sistem Manajemen Laundry Modern</strong> — Aplikasi manajemen laundry berbasis Laravel 11, dirancang untuk efisiensi operasional usaha laundry kecil & menengah.</p>
  <p>
    <img src="https://img.shields.io/badge/Laravel-11-FF2D20?logo=laravel" alt="Laravel 11">
    <img src="https://img.shields.io/badge/PHP-8.3-777BB4?logo=php" alt="PHP 8.3">
    <img src="https://img.shields.io/badge/SQLite-003B57?logo=sqlite" alt="SQLite">
    <img src="https://img.shields.io/badge/Bootstrap-5-7952B3?logo=bootstrap" alt="Bootstrap 5">
    <img src="https://img.shields.io/badge/license-MIT-blue" alt="MIT License">
  </p>
  <br>
</div>

## 📖 Tentang LaundryKu
LaundryKu adalah solusi digital terintegrasi untuk bisnis laundry. Sistem ini mencakup manajemen operasional lengkap, tracking status real-time, sistem poin loyalitas, serta pelaporan keuangan yang akurat untuk mendukung pengambilan keputusan bisnis.

## 📋 Daftar Isi

- [Fitur Utama](#-fitur)
- [Prasyarat](#-prasyarat)
- [Instalasi](#-instalasi)
- [Login Default](#-login-default)
- [Struktur Database](#-struktur-database)
- [Lisensi](#-lisensi)

---

## ✨ Fitur

| Fitur | Keterangan |
|-------|------------|
| 👥 **Manajemen Pelanggan** | CRUD pelanggan, detail riwayat transaksi, & sistem **Loyalty Points** (earn & redeem) |
| 🛠️ **Manajemen Layanan** | Kelola layanan kiloan/satuan & **Paket Laundry** |
| 📋 **Transaksi (Order)** | Tracking status (8 alur), **auto-lock saat selesai**, & **cetak barcode label** |
| 🔍 **Cek Status Publik** | Halaman tracking mandiri untuk pelanggan via nomor order |
| 💰 **Keuangan & Laporan** | Laporan laba-rugi (Chart.js), export Excel (.xlsx), & manajemen pengeluaran |
| 🛡️ **Stability & Safety** | **Activity log** audit, multi-role (Admin/Kasir/Owner), backup otomatis, & **double-submit prevention** |
| 🌗 **UI/UX Modern** | Bootstrap 5.3, **Dark Mode** persisten, & desain responsif |

---

## 🚀 Prasyarat

- **PHP** 8.1+
- **Composer** 2.x
- **Database** SQLite (dev) / MySQL 5.7+ (prod)
- **Ekstensi PHP**: `bcmath`, `ctype`, `fileinfo`, `json`, `mbstring`, `openssl`, `pdo`, `xml`

---

## 🛠️ Instalasi

```bash
git clone https://github.com/afdhalpower/laravel-laundry.git
cd laravel-laundry
composer install --no-dev --optimize-autoloader
cp .env.example .env
php artisan key:generate
php artisan migrate --seed
php artisan storage:link
php artisan serve
```

---

## 🔐 Login Default

| Role | Email | Password |
|------|-------|----------|
| Admin | `admin@laundryku.com` | `password` |
| Kasir | `kasir@laundryku.com` | `password` |
| Owner | `owner@laundryku.com` | `password` |

---

## 🗂️ Struktur Database
`users`, `customers`, `orders`, `order_items`, `services`, `payments`, `expenses`, `packages`, `loyalty_points`, `activity_logs`

---

## 📄 Lisensi
**MIT License** — © 2026 [afdhalpower](https://github.com/afdhalpower)
