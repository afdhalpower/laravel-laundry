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
| 👥 **Manajemen Pelanggan** | CRUD pelanggan dengan pencarian, **detail + riwayat transaksi** |
| 🛠️ **Layanan Laundry** | Kelola layanan kiloan & satuan, masing-masing dengan harga dan estimasi |
| 📋 **Transaksi / Order** | Buat order dengan multiple item, pilih layanan, tracking status otomatis |
| 🔄 **Status Tracking** | Alur: Diterima → Dicuci → Dikeringkan → Disetrika → Dilipat → Siap → Diantar → Selesai |
| 🔍 **Cek Status Publik** | Pelanggan cek status pakaian via **landing page** menggunakan nomor order dari invoice + **progress timeline visual** |
| 💰 **Pembayaran** | Catat pembayaran, histori cicilan, **edit/hapus pembayaran**, indikator lunas/sisa otomatis, **auto-advance status** saat lunas |
| 🗑️ **Trash & Restore** | Order yang dihapus masuk ke **Trash**, bisa direstore kapan saja |
| 📊 **Export Excel** | Laporan bisa **diexport ke format Excel (.xlsx)** |
| 🖨️ **Invoice** | Cetak struk invoice, siap untuk thermal printer 58mm |
| 📊 **Dashboard** | Statistik real-time (hari ini & 7 hari), grafik pendapatan, order terbaru |
| 📈 **Laporan** | Filter tanggal, grafik pendapatan, daftar transaksi lengkap |
| 🌐 **Landing Page** | Halaman publik dengan hero, layanan, testimoni, galeri, CTA WhatsApp, dan **Cek Status** — dikelola dari admin |
| 📱 **Responsive** | Bootstrap 5, mobile-first, bekerja di HP & desktop |

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

> **Catatan:** Untuk MySQL, ubah `DB_CONNECTION=sqlite` menjadi `DB_CONNECTION=mysql` di `.env` dan isi kredensial database.

---

## 🔐 Login Default

| Role | Email | Password |
|------|-------|----------|
| Admin | `admin@laundryku.com` | `password` |

> ⚠️ **Segera ganti password** setelah pertama kali login pada lingkungan produksi.

---

## 🏗️ Deployment ke Shared Hosting

| Langkah | Detail |
|---------|--------|
| **1. Upload** | Upload semua file ke hosting (kecuali folder `storage` bawaan Laravel) |
| **2. Document Root** | Arahkan Document Root ke folder `public/` |
| **3. Database** | Buat database MySQL via phpMyAdmin / cPanel |
| **4. Environment** | Edit `.env` — ganti `sqlite` → `mysql`, isi kredensial DB |
| **5. Migrasi** | Jalankan `php artisan migrate --seed` via SSH/Terminal |
| **6. Permission** | Set permission `storage/` dan `bootstrap/cache/` ke `755` |
| **7. Selesai** | Website siap diakses |

---

## 🗂️ Struktur Database

```
customers ──→ orders ──→ order_items ──→ services
                  │
                  └──→ payments
```

### Model Utama

| Model | Tabel | Keterangan |
|-------|-------|------------|
| `Customer` | `customers` | Data pelanggan (nama, telepon, alamat) |
| `Service` | `services` | Jenis layanan (nama, tipe, harga, estimasi) |
| `Order` | `orders` | Transaksi utama (no_order, tgl, status, total, soft delete) |
| `OrderItem` | `order_items` | Item detail transaksi (layanan, berat/jumlah, subtotal) |
| `Payment` | `payments` | Riwayat pembayaran (jumlah, metode, tanggal) |
| `SiteSetting` | `site_settings` | Pengaturan landing page (hero, tentang, kontak) |
| `Testimonial` | `testimonials` | Testimoni pelanggan untuk landing page |
| `Gallery` | `galleries` | Foto galeri untuk landing page |

### Alur Cek Status Publik

```
Admin buat transaksi → cetak invoice dengan No. Order (LND260718XXX)
                           ↓
Pelanggan buka https://laundryku.com/cek-status
                           ↓
Masukkan No. Order → lihat status real-time + progress timeline
```

---

## 🎨 Tampilan

| Area | Teknologi |
|------|-----------|
| **Admin Panel** | Bootstrap 5.3, sidebar gradasi navy, Inter font |
| **Landing Page** | Custom design, bento grid, scroll reveal animation, responsive |
| **Cek Status** | Halaman publik dengan search bar, kartu info, progress timeline 8 tahap, tabel layanan, status bayar |
| **Detail Pelanggan** | Kartu info pelanggan + tabel riwayat transaksi dengan pagination |
| **Dashboard** | 4 kartu statistik + grafik Chart.js (7 hari) + daftar order terbaru |
| **Invoice** | Via Bootstrap, siap cetak thermal printer 58mm |
| **Trash Order** | Daftar order yang dihapus dengan tombol restore |
| **Notifikasi** | Flash message sukses/error via Bootstrap alert |
| **Auth** | Laravel Breeze Blade dengan layout konsisten |

---

## 🛠️ Tech Stack

| Layer | Teknologi |
|-------|-----------|
| **Backend** | Laravel 11, PHP 8.3 |
| **Database** | SQLite (dev) / MySQL 5.7+ (prod) |
| **Frontend** | Bootstrap 5.3, Chart.js 4, Bootstrap Icons |
| **Export** | Laravel Excel (Maatwebsite) — format .xlsx |
| **Auth** | Laravel Breeze (Blade + Tailwind CSS) |
| **Font** | Inter (Google Fonts) |
| **Animasi** | Intersection Observer API, CSS transitions |

---

## 📄 Lisensi

**MIT License** — © 2026 [afdhalpower](https://github.com/afdhalpower)

Dipersilakan untuk digunakan, dimodifikasi, dan didistribusikan kembali.
