# Audit Fix 1-8 Implementation Plan

**Goal:** Fix all 8 findings from codebase audit — bugs, potential issues, and missing basic features.

**Approach:** Batch independent tasks via parallel subagents where possible, fix sequentially where dependencies exist.

**Design standard:** Anti-AI-slop — setiap halaman baru harus konsisten dengan existing Bootstrap 5.3 + Inter font + navy theme. Gunakan pola yang sama seperti halaman existing (card, table, form layout).

---

### Batch A: Customer Detail Page (Task 1 + Task 8)

**Files:**
- Create: `resources/views/customers/show.blade.php`
- Modify: `app/Http/Controllers/CustomerController.php`
- Modify: `resources/views/customers/index.blade.php` (link nama ke detail)

Customer `show()` — tampilkan info pelanggan + daftar order-nya dalam tabel (mirip orders.index). Protek jika customer punya orders_count > 0.

### Batch B: Hapus Order di Daftar & Detail (Task 2)

**Files:**
- Modify: `resources/views/orders/index.blade.php` — tambah kolom Aksi + form DELETE (sama pola seperti customers/services)
- Modify: `resources/views/orders/show.blade.php` — tambah tombol hapus

### Batch C: Payment Edit/Delete + Auto Status Fix (Task 3 + Task 4)

**Files:**
- Create: `resources/views/orders/payment-edit.blade.php`
- Modify: `app/Http/Controllers/PaymentController.php` — tambah edit/update/destroy + routes
- Modify: `resources/views/orders/show.blade.php` — tambah tombol edit/hapus di riwayat payment

Auto-status: Ubah kondisi `in_array($order->status, ["siap"])` jadi `!in_array($order->status, ["diantar", "selesai"])` agar status auto-advance dari status manapun.

### Batch D: Fix Report Revenue + Order Count (Task 5)

**Files:**
- Modify: `app/Http/Controllers/ReportController.php` — revenue dihitung dari orders.total_harga WHERE any payment exists in range, bukan dari payments.tgl_bayar

### Batch E: Trash & Restore Order (Task 6)

**Files:**
- Create: `resources/views/orders/trash.blade.php`
- Modify: `app/Http/Controllers/OrderController.php` — tambah trash() + restore() methods
- Modify: `routes/web.php` — tambah routes trash + restore
- Modify: `resources/views/orders/index.blade.php` — tambah link ke trash

### Batch F: Export Excel (Task 7)

**Files:**
- Install: `composer require maatwebsite/excel`
- Create: `app/Exports/OrderExport.php`
- Modify: `app/Http/Controllers/ReportController.php` — tambah export() method
- Modify: `routes/web.php` — tambah route export
- Modify: `resources/views/reports/index.blade.php` — tambah tombol Export Excel
