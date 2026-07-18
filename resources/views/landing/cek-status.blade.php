{{-- Cek Status Laundry --}}
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=5">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Cek Status Laundry · LaundryKu</title>
    <meta name="description" content="Cek status pakaian Anda — masukkan nomor order yang tertera di invoice.">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">

    <style>
        :root {
            --navy: #1a237e; --navy-dark: #0d1b4a;
            --accent: #42a5f5; --accent-soft: #e3f2fd;
            --ink: #1a1a2e; --muted: #6b7280; --surface: #f8fafc;
            --space-section: 5rem; --ease-out: cubic-bezier(0.16, 1, 0.3, 1);
            --dur-short: 220ms;
        }
        * { margin:0; padding:0; box-sizing:border-box; }
        body { font-family:Inter,system-ui,-apple-system,sans-serif; color:var(--ink); background:#fff; line-height:1.6; }

        .lp-nav { position:fixed; top:0; left:0; right:0; z-index:1030; background:rgba(255,255,255,0.88); backdrop-filter:blur(16px); border-bottom:1px solid #eef2f6; transition:background .22s var(--ease-out); }
        .lp-nav.scrolled { background:rgba(255,255,255,0.96); box-shadow:0 1px 12px rgba(0,0,0,0.04); }
        .lp-nav .container { display:flex; align-items:center; justify-content:space-between; height:64px; }
        .lp-nav .brand { font-weight:800; font-size:1.2rem; color:var(--navy); letter-spacing:-.02em; text-decoration:none; }
        .lp-nav .brand i { color:var(--accent); margin-right:.4rem; }
        .lp-nav .nav-links { display:flex; gap:2rem; align-items:center; }
        .lp-nav .nav-links a { color:var(--muted); text-decoration:none; font-size:.875rem; font-weight:500; transition:color .15s; position:relative; }
        .lp-nav .nav-links a::after { content:""; position:absolute; bottom:-2px; left:0; width:0; height:2px; background:var(--navy); transition:width var(--dur-short) var(--ease-out); border-radius:1px; }
        .lp-nav .nav-links a:hover { color:var(--navy); }
        .lp-nav .nav-links a:hover::after { width:100%; }
        .lp-nav .nav-links a.active { color:var(--navy); font-weight:600; }
        .lp-nav .nav-links a.active::after { width:100%; }
        .lp-nav-toggler { display:none; background:none; border:none; font-size:1.5rem; color:var(--navy); cursor:pointer; }

        section { padding:var(--space-section) 0; }
        .section-label { font-size:.75rem; font-weight:600; text-transform:uppercase; letter-spacing:.1em; color:var(--accent); margin-bottom:1rem; }

        .lp-hero { padding:8rem 0 4rem; background:linear-gradient(165deg,var(--navy) 0%,var(--navy-dark) 100%); color:#fff; position:relative; overflow:hidden; }
        .lp-hero::before { content:""; position:absolute; inset:0; background:radial-gradient(ellipse at 30% 50%, rgba(66,165,245,.15) 0%,transparent 60%),radial-gradient(ellipse at 70% 80%, rgba(66,165,245,.06) 0%,transparent 50%); }
        .lp-hero .container { position:relative; z-index:1; }

        .search-box { max-width:580px; margin:0 auto; }
        .search-box .input-group { background:#fff; border-radius:100px; overflow:hidden; box-shadow:0 4px 20px rgba(0,0,0,0.08); }
        .search-box .input-group input { border:none; padding:.9rem 1.5rem; font-size:1rem; }
        .search-box .input-group input:focus { box-shadow:none; }
        .search-box .input-group .btn { border:none; padding:0 2rem; font-weight:600; font-size:.95rem; }
        .search-hint { font-size:.85rem; color:rgba(255,255,255,0.5); margin-top:.75rem; }

        .status-card { max-width:680px; margin:2rem auto 0; background:#fff; border-radius:20px; box-shadow:0 8px 32px rgba(0,0,0,0.06); overflow:hidden; }
        .status-card .card-body { padding:2rem; }
        .status-card .order-header { display:flex; justify-content:space-between; align-items:center; flex-wrap:wrap; gap:.5rem; margin-bottom:1.25rem; padding-bottom:1rem; border-bottom:1px solid #eef2f6; }
        .status-card .order-no { font-size:1.1rem; font-weight:800; color:var(--navy); letter-spacing:-.02em; }
        .status-card .customer-name { color:var(--muted); font-size:.9rem; }
        .status-card .badge-status { display:inline-flex; align-items:center; gap:.4rem; padding:.35rem 1rem; border-radius:100px; font-size:.8rem; font-weight:600; }
        .status-card .badge-status i { font-size:.75rem; }
        .status-card .info-grid { display:grid; grid-template-columns:1fr 1fr; gap:1rem; margin-bottom:1.25rem; }
        .status-card .info-item { background:var(--surface); padding:.9rem 1rem; border-radius:12px; }
        .status-card .info-item .label { font-size:.75rem; color:var(--muted); text-transform:uppercase; letter-spacing:.05em; margin-bottom:.2rem; }
        .status-card .info-item .value { font-weight:700; font-size:.95rem; color:var(--ink); }

        .progress-track { display:flex; justify-content:space-between; margin:1.5rem 0 .5rem; position:relative; }
        .progress-track::before { content:""; position:absolute; top:14px; left:14px; right:14px; height:2px; background:#e5e7eb; z-index:0; }
        .progress-track .step { display:flex; flex-direction:column; align-items:center; gap:.4rem; position:relative; z-index:1; flex:1; }
        .progress-track .step .dot { width:30px; height:30px; border-radius:50%; background:#e5e7eb; display:flex; align-items:center; justify-content:center; font-size:.75rem; color:#fff; transition:background .3s; }
        .progress-track .step.done .dot { background:var(--accent); }
        .progress-track .step.current .dot { background:var(--navy); box-shadow:0 0 0 4px rgba(26,35,126,0.15); }
        .progress-track .step .label { font-size:.65rem; color:var(--muted); text-align:center; max-width:60px; line-height:1.2; }
        .progress-track .step.done .label { color:var(--navy); font-weight:600; }
        .progress-track .step.current .label { color:var(--navy); font-weight:700; }

        .status-card .items-table { width:100%; font-size:.85rem; margin-top:.5rem; }
        .status-card .items-table th { background:var(--surface); padding:.5rem .75rem; font-weight:600; font-size:.75rem; text-transform:uppercase; letter-spacing:.05em; }
        .status-card .items-table td { padding:.5rem .75rem; border-bottom:1px solid #f3f4f6; }
        .status-card .items-table tfoot td { font-weight:700; padding:.75rem; border-top:2px solid var(--navy); }

        .not-found { max-width:480px; margin:2rem auto 0; text-align:center; }
        .not-found .icon { font-size:3rem; color:#d1d5db; margin-bottom:1rem; }

        .lp-cta { background:var(--surface); text-align:center; }
        .lp-cta h2 { font-size:clamp(1.25rem,2.5vw,1.75rem); font-weight:800; margin-bottom:.75rem; }
        .lp-cta p { color:var(--muted); margin-bottom:1.5rem; font-size:.95rem; }
        .lp-cta .btn-wa-large { display:inline-flex; align-items:center; gap:.5rem; background:#25d366; color:#fff; border:none; border-radius:100px; padding:.85rem 2.5rem; font-weight:700; font-size:1rem; text-decoration:none; transition:background .15s; }
        .lp-cta .btn-wa-large:hover { background:#1da851; }

        .lp-footer { background:var(--navy-dark); color:rgba(255,255,255,.5); font-size:.85rem; padding:2.5rem 0; }
        .lp-footer .container { display:flex; justify-content:space-between; align-items:center; flex-wrap:wrap; gap:1rem; }

        @media (max-width:768px) {
            .lp-nav .nav-links { display:none; position:absolute; top:64px; left:0; right:0; background:rgba(255,255,255,.98); flex-direction:column; padding:1rem; border-bottom:1px solid #eef2f6; gap:1rem; }
            .lp-nav .nav-links.open { display:flex; }
            .lp-nav-toggler { display:block; }
            .status-card .info-grid { grid-template-columns:1fr; }
            .progress-track { flex-wrap:wrap; gap:.5rem; }
            .progress-track::before { display:none; }
            .progress-track .step { flex-direction:row; gap:.5rem; flex-basis:45%; }
            .lp-cta .btn-wa-large { font-size:.9rem; padding:.7rem 1.8rem; }
            .lp-footer .container { flex-direction:column; text-align:center; }
        }
        @media (max-width:480px) {
            :root { --space-section:3rem; }
            .status-card .card-body { padding:1.25rem; }
            .status-card .info-grid { grid-template-columns:1fr; }
        }
    </style>
</head>
<body>

{{-- Nav --}}
<nav class="lp-nav" id="navbar">
    <div class="container">
        <a href="{{ route("home") }}" class="brand"><i class="bi bi-droplet-half"></i>LaundryKu</a>
        <button class="lp-nav-toggler" id="navToggler" aria-label="Menu"><i class="bi bi-list"></i></button>
        <div class="nav-links" id="navLinks">
            <a href="{{ route("home") }}#layanan">Layanan</a>
            <a href="{{ route("home") }}#tentang">Tentang</a>
            <a href="{{ route("cek.status") }}" class="active"><i class="bi bi-search me-1"></i>Cek Status</a>
            <a href="{{ route("home") }}#kontak">Kontak</a>
            @if ($settings["whatsapp_number"] ?? null)
                <a href="https://wa.me/{{ $settings["whatsapp_number"] }}" class="btn-wa" target="_blank">
                    <i class="bi bi-whatsapp"></i> {{ $settings["hero_cta_text"] ?? "Pesan" }}
                </a>
            @endif
        </div>
    </div>
</nav>

{{-- Hero Search --}}
<section class="lp-hero">
    <div class="container text-center">
        <div class="section-label" style="color:rgba(255,255,255,0.4)">Cek Status</div>
        <h1 style="font-size:clamp(1.5rem,3.5vw,2.4rem);font-weight:900;letter-spacing:-.03em;color:#fff;margin-bottom:.75rem">Di mana status pakaian saya?</h1>
        <p style="color:rgba(255,255,255,0.6);max-width:450px;margin:0 auto 1.5rem;font-size:.95rem">
            Masukkan nomor order yang tertera di invoice Anda.
        </p>

        <form action="{{ route("cek.status") }}" method="GET" class="search-box">
            <div class="input-group">
                <input type="text" name="no_order" class="form-control" placeholder="Contoh: LND260718001" value="{{ request("no_order") }}" required autofocus>
                <button class="btn btn-primary" type="submit"><i class="bi bi-search me-1"></i> Cari</button>
            </div>
            <div class="search-hint">Contoh nomor order: <strong>LND260718001</strong></div>
        </form>
    </div>
</section>

{{-- Result --}}
@if($order || $notFound)
<section>
    <div class="container">
        @if($order)
            <div class="status-card">
                <div class="card-body">

                    {{-- Header --}}
                    <div class="order-header">
                        <div>
                            <div class="order-no"><i class="bi bi-receipt me-1"></i>{{ $order->no_order }}</div>
                            <div class="customer-name"><i class="bi bi-person me-1"></i>{{ $order->customer->nama }}</div>
                        </div>
                        @php
                            $isSelesai = $order->status == 'selesai';
                            $isProgress = in_array($order->status, ['dicuci','dikeringkan','disetrika','dilipat']);
                            $bgColor = $isSelesai ? '#d1fae5' : ($isProgress ? '#dbeafe' : '#fef3c7');
                            $textColor = $isSelesai ? '#065f46' : ($isProgress ? '#1e40af' : '#92400e');
                        @endphp
                        <span class="badge-status" style="background:{{ $bgColor }};color:{{ $textColor }}">
                            <i class="bi bi-{{ $order->status == 'selesai' ? 'check-circle' : 'hourglass-split' }}"></i>
                            {{ $order->status_label }}
                        </span>
                    </div>

                    {{-- Info Grid --}}
                    <div class="info-grid">
                        <div class="info-item">
                            <div class="label">Tanggal Masuk</div>
                            <div class="value">{{ $order->tgl_masuk->isoFormat("D MMMM Y") }}</div>
                        </div>
                        <div class="info-item">
                            <div class="label">Estimasi Selesai</div>
                            <div class="value">{{ $order->tgl_selesai?->isoFormat("D MMMM Y") ?? "Belum ditentukan" }}</div>
                        </div>
                        @if($order->catatan)
                        <div class="info-item" style="grid-column:1/-1">
                            <div class="label">Catatan</div>
                            <div class="value">{{ $order->catatan }}</div>
                        </div>
                        @endif
                    </div>

                    {{-- Progress Timeline --}}
                    @php
                        $steps = ['diterima','dicuci','dikeringkan','disetrika','dilipat','siap','diantar','selesai'];
                        $statusIdx = array_search($order->status, $steps);
                        $labels = ['Diterima','Dicuci','Dikeringkan','Disetrika','Dilipat','Siap','Diantar','Selesai'];
                        $icons = ['inbox','water','wind','thermometer-half','box-seam','check2','truck','check-circle'];
                    @endphp
                    <div class="progress-track">
                        @foreach($steps as $i => $s)
                            @php $cls = $i < $statusIdx ? 'done' : ($i == $statusIdx ? 'current' : ''); @endphp
                            <div class="step {{ $cls }}">
                                <div class="dot"><i class="bi bi-{{ $icons[$i] }}"></i></div>
                                <div class="label">{{ $labels[$i] }}</div>
                            </div>
                        @endforeach
                    </div>

                    {{-- Items Table --}}
                    @if($order->items->count())
                    <div style="margin-top:1.5rem;padding-top:1rem;border-top:1px solid #eef2f6">
                        <div style="font-size:.75rem;font-weight:600;text-transform:uppercase;letter-spacing:.05em;color:var(--muted);margin-bottom:.5rem">Detail Layanan</div>
                        <table class="items-table">
                            <thead><tr><th>Layanan</th><th>Tipe</th><th class="text-end">Harga</th><th class="text-end">Subtotal</th></tr></thead>
                            <tbody>
                                @foreach($order->items as $item)
                                <tr>
                                    <td>{{ $item->service->nama }}</td>
                                    <td>
                                        @if($item->jenis == 'kiloan')
                                            <span class="badge bg-info bg-opacity-10 text-info">{{ $item->berat }} kg</span>
                                        @else
                                            <span class="badge bg-warning bg-opacity-10 text-warning">{{ $item->jumlah }} pcs</span>
                                        @endif
                                    </td>
                                    <td class="text-end">Rp {{ number_format($item->harga_satuan, 0, ',', '.') }}</td>
                                    <td class="text-end fw-semibold">Rp {{ number_format($item->subtotal, 0, ',', '.') }}</td>
                                </tr>
                                @endforeach
                            </tbody>
                            <tfoot><tr><td colspan="3" class="text-end fw-bold">Total</td><td class="text-end fw-bold">Rp {{ number_format($order->total_harga, 0, ',', '.') }}</td></tr></tfoot>
                        </table>
                    </div>
                    @endif

                    {{-- Payment status --}}
                    @php
                        $totalBayar = $order->payments->sum('jumlah');
                        $sisa = $order->total_harga - $totalBayar;
                    @endphp
                    <div style="margin-top:1rem;padding-top:1rem;border-top:1px solid #eef2f6;display:flex;justify-content:space-between;align-items:center;flex-wrap:wrap;gap:.5rem">
                        <div>
                            <span style="font-size:.8rem;color:var(--muted)">Pembayaran: </span>
                            @if($sisa <= 0)
                                <span class="badge bg-success"><i class="bi bi-check-circle me-1"></i>Lunas</span>
                            @else
                                <span class="badge bg-warning text-dark">Sisa Rp {{ number_format($sisa, 0, ',', '.') }}</span>
                            @endif
                        </div>
                        <div style="font-size:.8rem;color:var(--muted)">
                            Total: <strong style="color:var(--navy)">Rp {{ number_format($order->total_harga, 0, ',', '.') }}</strong>
                        </div>
                    </div>

                </div>
            </div>
        @elseif($notFound)
            <div class="not-found">
                <div class="icon"><i class="bi bi-search-heart"></i></div>
                <h3 style="font-weight:700;font-size:1.15rem;margin-bottom:.5rem">Order tidak ditemukan</h3>
                <p style="color:var(--muted);font-size:.9rem">Nomor order <strong>&quot;{{ request("no_order") }}&quot;</strong> tidak terdaftar. Periksa kembali nomor pada invoice Anda.</p>
            </div>
        @endif
    </div>
</section>
@endif

{{-- CTA --}}
<section class="lp-cta">
    <div class="container">
        <h2 style="font-size:clamp(1.25rem,2.5vw,1.75rem);font-weight:800;margin-bottom:.75rem">Belum punya akun?</h2>
        <p style="color:var(--muted);margin-bottom:1.5rem;font-size:.95rem">Daftar sekarang dan nikmati kemudahan laundry tanpa ribet.</p>
        @if ($settings["whatsapp_number"] ?? null)
            <a href="https://wa.me/{{ $settings["whatsapp_number"] }}" class="btn-wa-large" target="_blank"><i class="bi bi-whatsapp fs-5"></i> Hubungi Kami</a>
        @endif
    </div>
</section>

{{-- Footer --}}
<footer class="lp-footer">
    <div class="container">
        <span>{{ $settings["footer_text"] ?? "© " . date("Y") . " LaundryKu. All rights reserved." }}</span>
        @if($settings["address"] ?? null)
            <span><i class="bi bi-geo-alt me-1"></i> {{ $settings["address"] }}</span>
        @endif
    </div>
</footer>

<script>
(function() {
    "use strict";
    var nav = document.getElementById("navbar");
    var ticking = false;
    window.addEventListener("scroll", function() {
        if (!ticking) {
            window.requestAnimationFrame(function() {
                if (nav) nav.classList.toggle("scrolled", (window.scrollY || window.pageYOffset) > 80);
                ticking = false;
            });
            ticking = true;
        }
    }, { passive: true });
    var toggler = document.getElementById("navToggler");
    var navLinks = document.getElementById("navLinks");
    if (toggler && navLinks) {
        toggler.addEventListener("click", function() { navLinks.classList.toggle("open"); });
        navLinks.querySelectorAll("a").forEach(function(l) {
            l.addEventListener("click", function() { navLinks.classList.remove("open"); });
        });
    }
})();
</script>
</body>
</html>