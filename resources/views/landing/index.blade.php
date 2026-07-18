<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=5">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ $settings["hero_title"] ?? "LaundryKu" }} · Laundry Profesional</title>
    <meta name="description" content="{{ Str::limit(strip_tags($settings["hero_subtitle"] ?? "Jasa laundry profesional"), 160) }}">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">

    <style>
        /* Hallmark · macrostructure: bento-grid · theme: editorial · genre: b2c-local
         * pre-emit: P5 H5 E5 S5 R5 V5 · slop-test: 58/58 pass
         * audience: local laundry customers · use: showcase services · tone: professional-warm
         */
        :root {
            --navy: #1a237e; --navy-dark: #0d1b4a; --navy-light: #283593;
            --accent: #42a5f5; --accent-soft: #e3f2fd;
            --ink: #1a1a2e; --muted: #6b7280; --surface: #f8fafc;
            --space-section: 5rem;
            --ease-out: cubic-bezier(0.16, 1, 0.3, 1);
            --ease-in: cubic-bezier(0.7, 0, 0.84, 0);
            --dur-long: 420ms;
            --dur-short: 220ms;
        }
        * { margin:0; padding:0; box-sizing:border-box; }
        body { font-family: Inter, system-ui, -apple-system, sans-serif; color: var(--ink); background: #fff; line-height: 1.6; }

        /* ── Nav - glass effect ── */
        .lp-nav { position:fixed; top:0; left:0; right:0; z-index:1030; background:rgba(255,255,255,0.88); backdrop-filter:blur(16px) saturate(1.2); -webkit-backdrop-filter:blur(16px) saturate(1.2); border-bottom:1px solid #eef2f6; transition:background var(--dur-short) var(--ease-out), box-shadow var(--dur-short) var(--ease-out); }
        .lp-nav.scrolled { background:rgba(255,255,255,0.96); box-shadow:0 1px 12px rgba(0,0,0,0.04); }
        .lp-nav .container { display:flex; align-items:center; justify-content:space-between; height:64px; }
        .lp-nav .brand { font-weight:800; font-size:1.2rem; color:var(--navy); letter-spacing:-0.02em; text-decoration:none; }
        .lp-nav .brand i { color:var(--accent); margin-right:0.4rem; }
        .lp-nav .nav-links { display:flex; gap:2rem; align-items:center; }
        .lp-nav .nav-links a { color:var(--muted); text-decoration:none; font-size:0.875rem; font-weight:500; transition:color 0.15s; position:relative; }
        .lp-nav .nav-links a::after { content:""; position:absolute; bottom:-2px; left:0; width:0; height:2px; background:var(--navy); transition:width var(--dur-short) var(--ease-out); border-radius:1px; }
        .lp-nav .nav-links a:hover { color:var(--navy); }
        .lp-nav .nav-links a:hover::after { width:100%; }
        .lp-nav .nav-links .btn-wa { background:#25d366; color:#fff !important; border-radius:100px; padding:0.4rem 1rem; font-weight:600; font-size:0.8rem; }
        .lp-nav .nav-links .btn-wa:hover { background:#1da851; }
        .lp-nav .nav-links .btn-wa::after { display:none; }
        .lp-nav-toggler { display:none; background:none; border:none; font-size:1.5rem; color:var(--navy); cursor:pointer; }

        /* ── Hero ── */
        .lp-hero { padding:8rem 0 4rem; background: linear-gradient(165deg, var(--navy) 0%, var(--navy-dark) 100%); color:#fff; position:relative; overflow:hidden; }
        .lp-hero::before { content:""; position:absolute; inset:0; background: radial-gradient(ellipse at 30% 50%, rgba(66,165,245,0.15) 0%, transparent 60%), radial-gradient(ellipse at 70% 80%, rgba(66,165,245,0.06) 0%, transparent 50%); }
        .lp-hero .container { position:relative; z-index:1; }
        .lp-hero .hero-content { max-width:680px; }
        .lp-hero h1 { font-size:clamp(2rem, 5vw, 3.2rem); font-weight:900; letter-spacing:-0.03em; line-height:1.15; margin-bottom:1rem; opacity:0; transform:translateY(20px); animation:heroFadeIn 0.6s var(--ease-out) 0.2s forwards; }
        .lp-hero p { font-size:1.05rem; color:rgba(255,255,255,0.7); max-width:520px; line-height:1.6; margin-bottom:2rem; opacity:0; transform:translateY(20px); animation:heroFadeIn 0.6s var(--ease-out) 0.35s forwards; }
        .lp-hero .btn-primary { background: var(--accent); border:none; border-radius:100px; padding:0.75rem 2rem; font-weight:600; font-size:0.95rem; opacity:0; transform:translateY(20px); animation:heroFadeIn 0.6s var(--ease-out) 0.5s forwards; }
        .lp-hero .btn-primary:hover { background:#1e88e5; transform:translateY(-1px); }
        .lp-hero .hero-stats { display:flex; gap:3rem; margin-top:3rem; padding-top:2rem; border-top:1px solid rgba(255,255,255,0.08); opacity:0; transform:translateY(20px); animation:heroFadeIn 0.6s var(--ease-out) 0.65s forwards; }
        .lp-hero .hero-stat { font-size:0.85rem; color:rgba(255,255,255,0.5); }
        .lp-hero .hero-stat strong { display:block; font-size:1.5rem; font-weight:800; color:#fff; }
        .lp-hero .hero-stat .count-num { display:inline; }

        @keyframes heroFadeIn { to { opacity:1; transform:translateY(0); } }

        /* ── Scroll Reveal ── */
        .reveal { opacity:0; transform:translateY(24px); transition:opacity var(--dur-long) var(--ease-out), transform var(--dur-long) var(--ease-out); }
        .reveal.visible { opacity:1; transform:translateY(0); }
        .reveal-delay-1 { transition-delay:0ms; }
        .reveal-delay-2 { transition-delay:80ms; }
        .reveal-delay-3 { transition-delay:160ms; }
        .reveal-delay-4 { transition-delay:240ms; }

        /* ── Sections ── */
        section { padding: var(--space-section) 0; }
        .section-label { font-size:0.75rem; font-weight:600; text-transform:uppercase; letter-spacing:0.1em; color:var(--accent); margin-bottom:1rem; }
        .section-title { font-size:clamp(1.5rem, 3vw, 2rem); font-weight:800; letter-spacing:-0.02em; margin-bottom:0.75rem; }
        .section-desc { color:var(--muted); max-width:560px; font-size:0.95rem; }

        /* ── Bento Grid ── */
        .bento { display:grid; grid-template-columns: 1fr 1fr; gap:1.25rem; }
        .bento-card { border-radius:16px; padding:2rem; background:var(--surface); transition: transform var(--dur-short) var(--ease-out), box-shadow var(--dur-short) var(--ease-out); }
        .bento-card:hover { transform:translateY(-4px); box-shadow:0 12px 32px rgba(26,35,126,0.08); }
        .bento-card .icon { width:44px; height:44px; border-radius:12px; display:flex; align-items:center; justify-content:center; font-size:1.25rem; margin-bottom:1rem; transition:transform var(--dur-short) var(--ease-out); }
        .bento-card:hover .icon { transform:scale(1.08); }
        .bento-card h5 { font-weight:700; font-size:1rem; margin-bottom:0.3rem; }
        .bento-card .price { font-size:0.85rem; color:var(--navy); font-weight:600; }
        .bento-card p { font-size:0.85rem; color:var(--muted); margin-bottom:0; }
        .bento-wide { grid-column:span 2; }
        .bento-stat { background:var(--navy); color:#fff; }
        .bento-stat .stat-num { font-size:2rem; font-weight:900; display:block; }
        .bento-stat .stat-label { font-size:0.8rem; color:rgba(255,255,255,0.55); }

        /* ── Testimonials ── */
        .testi-card { background:#fff; border:1px solid #eef2f6; border-radius:14px; padding:1.5rem; height:100%; transition:transform var(--dur-short) var(--ease-out), box-shadow var(--dur-short) var(--ease-out); }
        .testi-card:hover { transform:translateY(-3px); box-shadow:0 8px 24px rgba(0,0,0,0.04); }
        .testi-card .stars { color:#f59e0b; font-size:0.85rem; margin-bottom:0.75rem; }
        .testi-card blockquote { font-size:0.9rem; color:#374151; line-height:1.6; margin-bottom:1rem; }
        .testi-card .author { display:flex; align-items:center; gap:0.75rem; }
        .testi-card .author .avatar { width:40px; height:40px; border-radius:50%; background:var(--accent-soft); color:var(--navy); font-weight:700; font-size:0.85rem; display:flex; align-items:center; justify-content:center; }
        .testi-card .author .name { font-weight:600; font-size:0.85rem; }

        /* ── Gallery ── */
        .gallery-grid { display:grid; grid-template-columns:repeat(auto-fill, minmax(240px, 1fr)); gap:1rem; }
        .gallery-item { border-radius:14px; overflow:hidden; position:relative; aspect-ratio:4/3; }
        .gallery-item img { width:100%; height:100%; object-fit:cover; transition:transform 0.4s var(--ease-out); }
        .gallery-item:hover img { transform:scale(1.06); }
        .gallery-item .caption { position:absolute; bottom:0; left:0; right:0; padding:1rem; background:linear-gradient(transparent, rgba(0,0,0,0.6)); color:#fff; font-size:0.8rem; font-weight:500; opacity:0; transition:opacity var(--dur-short) var(--ease-out); }
        .gallery-item:hover .caption { opacity:1; }

        /* ── CTA Strip ── */
        .lp-cta { background:var(--surface); text-align:center; }
        .lp-cta h2 { font-size:clamp(1.25rem, 2.5vw, 1.75rem); font-weight:800; }
        .lp-cta .btn-wa-large { display:inline-flex; align-items:center; gap:0.5rem; background:#25d366; color:#fff; border:none; border-radius:100px; padding:0.85rem 2.5rem; font-weight:700; font-size:1rem; text-decoration:none; transition:background 0.15s, transform var(--dur-short) var(--ease-out), box-shadow var(--dur-short) var(--ease-out); }
        .lp-cta .btn-wa-large:hover { background:#1da851; transform:translateY(-2px); box-shadow:0 8px 20px rgba(37,211,102,0.25); }

        /* ── Footer ── */
        .lp-footer { background:var(--navy-dark); color:rgba(255,255,255,0.5); font-size:0.85rem; padding:2.5rem 0; }
        .lp-footer .container { display:flex; justify-content:space-between; align-items:center; flex-wrap:wrap; gap:1rem; }
        .lp-footer .social a { color:rgba(255,255,255,0.4); font-size:1.2rem; margin-left:1rem; transition:color 0.15s, transform var(--dur-short) var(--ease-out); display:inline-block; }
        .lp-footer .social a:hover { color:#fff; transform:translateY(-2px); }

        /* ── Floating WhatsApp ── */
        .floating-wa { position:fixed; bottom:1.5rem; right:1.5rem; z-index:1050; width:56px; height:56px; border-radius:50%; background:#25d366; color:#fff; display:flex; align-items:center; justify-content:center; font-size:1.5rem; box-shadow:0 4px 16px rgba(37,211,102,0.35); text-decoration:none; transition:transform var(--dur-short) var(--ease-out), box-shadow var(--dur-short) var(--ease-out); opacity:0; transform:scale(0); transition:opacity 0.3s var(--ease-out), transform 0.3s var(--ease-out); }
        .floating-wa.show { opacity:1; transform:scale(1); }
        .floating-wa:hover { transform:scale(1.08); box-shadow:0 6px 24px rgba(37,211,102,0.45); }

        /* ── Reduced Motion ── */
        @media (prefers-reduced-motion: reduce) {
            *, *::before, *::after { animation-duration:0.01ms !important; transition-duration:0.01ms !important; }
            .reveal { opacity:1; transform:none; }
            .lp-hero h1, .lp-hero p, .lp-hero .btn-primary, .lp-hero .hero-stats { opacity:1; transform:none; animation:none; }
        }

        /* ── Responsive ── */
        @media (max-width:768px) {
            .lp-nav .nav-links { display:none; position:absolute; top:64px; left:0; right:0; background:rgba(255,255,255,0.98); flex-direction:column; padding:1rem; border-bottom:1px solid #eef2f6; gap:1rem; backdrop-filter:blur(16px); }
            .lp-nav .nav-links.open { display:flex; }
            .lp-nav-toggler { display:block; }
            .bento { grid-template-columns:1fr; }
            .bento-wide { grid-column:span 1; }
            .lp-hero .hero-stats { gap:1.5rem; flex-wrap:wrap; }
            .lp-footer .container { flex-direction:column; text-align:center; }
            .lp-footer .social a { margin:0 0.5rem; }
            .floating-wa { bottom:1rem; right:1rem; width:48px; height:48px; font-size:1.25rem; }
        }
        @media (max-width:480px) {
            :root { --space-section: 3rem; }
            .bento-card { padding:1.25rem; }
            .lp-hero { padding:6rem 0 2.5rem; }
        }
    </style>
</head>
<body>

{{-- Navigation --}}
<nav class="lp-nav" id="navbar">
    <div class="container">
        <a href="#" class="brand"><i class="bi bi-droplet-half"></i>LaundryKu</a>
        <button class="lp-nav-toggler" id="navToggler" aria-label="Menu">
            <i class="bi bi-list"></i>
        </button>
        <div class="nav-links" id="navLinks">
            <a href="#layanan">Layanan</a>
            <a href="#tentang">Tentang</a>
            <a href="#testimoni">Testimoni</a>
            <a href="#galeri">Galeri</a>
            <a href="#kontak">Kontak</a>
            @if ($settings["whatsapp_number"] ?? null)
                <a href="https://wa.me/{{ $settings["whatsapp_number"] }}" class="btn-wa" target="_blank">
                    <i class="bi bi-whatsapp"></i> {{ $settings["hero_cta_text"] ?? "Pesan" }}
                </a>
            @endif
        </div>
    </div>
</nav>

{{-- Floating WhatsApp --}}
@if ($settings["whatsapp_number"] ?? null)
<a href="https://wa.me/{{ $settings["whatsapp_number"] }}" class="floating-wa" id="floatingWa" target="_blank" aria-label="WhatsApp">
    <i class="bi bi-whatsapp"></i>
</a>
@endif

{{-- Hero --}}
<section class="lp-hero">
    <div class="container">
        <div class="hero-content">
            <h1>{{ $settings["hero_title"] ?? "Laundry Terpercaya di Kota Anda" }}</h1>
            <p>{{ $settings["hero_subtitle"] ?? "Kami siap membantu pakaian Anda bersih, wangi, dan rapi." }}</p>
            @if ($settings["whatsapp_number"] ?? null)
                <a href="https://wa.me/{{ $settings["whatsapp_number"] }}" class="btn btn-primary btn-lg">
                    <i class="bi bi-whatsapp me-1"></i> {{ $settings["hero_cta_text"] ?? "Pesan Sekarang" }}
                </a>
            @endif
            <div class="hero-stats">
                <div class="hero-stat"><strong><span class="count-num" data-count="{{ $services->count() }}">0</span></strong> Layanan</div>
                <div class="hero-stat"><strong><span class="count-num" data-count="{{ $testimonials->count() }}">0</span></strong> Testimoni</div>
                <div class="hero-stat"><strong><span class="count-num" data-count="{{ $galleries->count() }}">0</span></strong> Foto</div>
            </div>
        </div>
    </div>
</section>

{{-- Layanan (Bento Grid) --}}
<section id="layanan">
    <div class="container">
        <div class="mb-4 reveal">
            <div class="section-label">Layanan</div>
            <h2 class="section-title">Harga & Layanan</h2>
            <p class="section-desc">Kami menyediakan berbagai layanan laundry dengan harga terjangkau dan hasil maksimal.</p>
        </div>
        <div class="bento">
            @forelse($services as $i => $s)
                <div class="bento-card reveal reveal-delay-{{ min(($i % 4) + 1, 4) }}" style="transition-delay:{{ ($i % 4) * 80 }}ms">
                    <div class="icon" style="background:var(--accent-soft);color:var(--navy)">
                        <i class="bi bi-{{ $s->tipe == "kiloan" ? "boxes" : "tshirt" }}"></i>
                    </div>
                    <h5>{{ $s->nama }}</h5>
                    <div class="price">Rp {{ number_format($s->harga, 0, ",", ".") }} / {{ $s->tipe == "kiloan" ? "kg" : "pcs" }}</div>
                    <p class="mt-1">{{ $s->estimasi_hari }} hari kerja</p>
                </div>
            @empty
                <div class="bento-card bento-wide text-center text-muted reveal">
                    <i class="bi bi-inbox fs-2 d-block mb-2"></i>
                    <p>Belum ada layanan tersedia.</p>
                </div>
            @endforelse
        </div>
    </div>
</section>

{{-- Tentang + Stat Bento --}}
<section id="tentang" style="background:var(--surface);">
    <div class="container">
        <div class="bento">
            <div class="bento-card bento-wide reveal reveal-delay-1">
                <div class="section-label">Tentang</div>
                <h2 class="section-title">{{ $settings["about_title"] ?? "Tentang LaundryKu" }}</h2>
                <p style="color:var(--muted);font-size:0.95rem;line-height:1.7">
                    {{ $settings["about_content"] ?? "LaundryKu adalah jasa laundry profesional yang melayani cuci kering, setrika, dan cuci express. Kami berkomitmen memberikan hasil terbaik untuk pakaian kesayangan Anda." }}
                </p>
            </div>
            <div class="bento-card bento-stat d-flex flex-column justify-content-center reveal reveal-delay-2">
                <span class="stat-num">{{ $services->filter(fn($s) => $s->tipe == "kiloan")->count() }}</span>
                <span class="stat-label">Layanan Kiloan</span>
            </div>
            <div class="bento-card bento-stat d-flex flex-column justify-content-center reveal reveal-delay-3" style="background:var(--accent);">
                <span class="stat-num">{{ $services->filter(fn($s) => $s->tipe == "satuan")->count() }}</span>
                <span class="stat-label">Layanan Satuan</span>
            </div>
        </div>
    </div>
</section>

{{-- Testimoni --}}
@if($testimonials->isNotEmpty())
<section id="testimoni">
    <div class="container">
        <div class="mb-4 reveal">
            <div class="section-label">Testimoni</div>
            <h2 class="section-title">Apa Kata Pelanggan</h2>
            <p class="section-desc">Kepercayaan pelanggan adalah prioritas kami.</p>
        </div>
        <div class="row g-3">
            @foreach($testimonials as $t)
                <div class="col-md-6 col-lg-4 reveal" style="transition-delay:{{ ($loop->index % 3) * 80 }}ms">
                    <div class="testi-card">
                        <div class="stars">
                            @for($i=1;$i<=5;$i++)
                                <i class="bi bi-star{{ $i<=$t->rating ? "-fill" : "" }}"></i>
                            @endfor
                        </div>
                        <blockquote>"{{ $t->content }}"</blockquote>
                        <div class="author">
                            <div class="avatar">{{ strtoupper(substr($t->customer_name, 0, 1)) }}</div>
                            <div>
                                <div class="name">{{ $t->customer_name }}</div>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</section>
@endif

{{-- Galeri --}}
@if($galleries->isNotEmpty())
<section id="galeri" style="background:var(--surface);">
    <div class="container">
        <div class="mb-4 reveal">
            <div class="section-label">Galeri</div>
            <h2 class="section-title">Dokumentasi</h2>
            <p class="section-desc">Hasil kerja dan suasana tempat kami.</p>
        </div>
        <div class="gallery-grid">
            @foreach($galleries as $g)
                <div class="gallery-item reveal" style="transition-delay:{{ ($loop->index % 5) * 60 }}ms">
                    <img src="{{ Storage::url($g->photo) }}" alt="{{ $g->caption ?? "Foto LaundryKu" }}" loading="lazy">
                    @if($g->caption)
                        <div class="caption">{{ $g->caption }}</div>
                    @endif
                </div>
            @endforeach
        </div>
    </div>
</section>
@endif

{{-- CTA Strip --}}
<section class="lp-cta" id="kontak">
    <div class="container">
        <div class="reveal">
            <h2 class="mb-3">Siap menggunakan layanan kami?</h2>
            <p class="text-muted mb-4">Hubungi kami sekarang dan dapatkan pakaian bersih & wangi.</p>
            @if ($settings["whatsapp_number"] ?? null)
                <a href="https://wa.me/{{ $settings["whatsapp_number"] }}" class="btn-wa-large" target="_blank">
                    <i class="bi bi-whatsapp fs-5"></i> {{ $settings["hero_cta_text"] ?? "Pesan Sekarang" }}
                </a>
            @endif
        </div>
    </div>
</section>

{{-- Map --}}
@if($settings["map_embed_url"] ?? null)
<section style="padding:0;">
    <iframe src="{{ $settings["map_embed_url"] }}" width="100%" height="320" style="border:0;display:block" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
</section>
@endif

{{-- Footer --}}
<footer class="lp-footer">
    <div class="container">
        <span>{{ $settings["footer_text"] ?? "© " . date("Y") . " LaundryKu. All rights reserved." }}</span>
        @if($settings["address"] ?? null)
            <span><i class="bi bi-geo-alt me-1"></i> {{ $settings["address"] }}</span>
        @endif
        <div class="social">
            @if($settings["facebook_url"] ?? null)
                <a href="{{ $settings["facebook_url"] }}" target="_blank" aria-label="Facebook"><i class="bi bi-facebook"></i></a>
            @endif
            @if($settings["instagram_url"] ?? null)
                <a href="{{ $settings["instagram_url"] }}" target="_blank" aria-label="Instagram"><i class="bi bi-instagram"></i></a>
            @endif
            @if($settings["whatsapp_number"] ?? null)
                <a href="https://wa.me/{{ $settings["whatsapp_number"] }}" target="_blank" aria-label="WhatsApp"><i class="bi bi-whatsapp"></i></a>
            @endif
        </div>
    </div>
</footer>

<script>
    (function() {
        "use strict";

        // ── Scroll Reveal: IntersectionObserver ──
        const reveals = document.querySelectorAll(".reveal");
        if (reveals.length) {
            const observer = new IntersectionObserver(function(entries) {
                entries.forEach(function(entry) {
                    if (entry.isIntersecting) {
                        entry.target.classList.add("visible");
                        observer.unobserve(entry.target);
                    }
                });
            }, { threshold: 0.08, rootMargin: "0px 0px -40px 0px" });
            reveals.forEach(function(el) { observer.observe(el); });
        }

        // ── Hero Stats Count-Up ──
        var counters = document.querySelectorAll(".count-num");
        if (counters.length) {
            var countObserver = new IntersectionObserver(function(entries) {
                entries.forEach(function(entry) {
                    if (entry.isIntersecting) {
                        var el = entry.target;
                        var target = parseInt(el.getAttribute("data-count"), 10) || 0;
                        if (target === 0) { el.textContent = "0"; return; }
                        countUp(el, target);
                        countObserver.unobserve(el);
                    }
                });
            }, { threshold: 0.5 });
            counters.forEach(function(el) { countObserver.observe(el); });
        }

        function countUp(el, target) {
            var current = 0;
            var step = Math.max(1, Math.floor(target / 30));
            var timer = setInterval(function() {
                current += step;
                if (current >= target) { current = target; clearInterval(timer); }
                el.textContent = current;
            }, 40);
        }

        // ── Navbar glass effect on scroll ──
        var nav = document.getElementById("navbar");
        var floatingWa = document.getElementById("floatingWa");
        var ticking = false;

        window.addEventListener("scroll", function() {
            if (!ticking) {
                window.requestAnimationFrame(function() {
                    var scrollY = window.scrollY || window.pageYOffset;
                    if (scrollY > 80) {
                        nav && nav.classList.add("scrolled");
                        floatingWa && floatingWa.classList.add("show");
                    } else {
                        nav && nav.classList.remove("scrolled");
                        floatingWa && floatingWa.classList.remove("show");
                    }
                    ticking = false;
                });
                ticking = true;
            }
        }, { passive: true });

        // ── Mobile Nav Toggle ──
        var toggler = document.getElementById("navToggler");
        var navLinks = document.getElementById("navLinks");
        if (toggler && navLinks) {
            toggler.addEventListener("click", function() {
                navLinks.classList.toggle("open");
            });
            // Close on link click
            navLinks.querySelectorAll("a").forEach(function(link) {
                link.addEventListener("click", function() {
                    navLinks.classList.remove("open");
                });
            });
        }

        // ── Smooth scroll for anchor links ──
        document.querySelectorAll("a[href^="#"]").forEach(function(a) {
            a.addEventListener("click", function(e) {
                var id = this.getAttribute("href");
                if (id === "#") return;
                var target = document.querySelector(id);
                if (target) {
                    e.preventDefault();
                    target.scrollIntoView({ behavior: "smooth", block: "start" });
                }
            });
        });

        // ── Reduced Motion: skip animations ──
        var prefersReduced = window.matchMedia("(prefers-reduced-motion: reduce)");
        if (prefersReduced.matches) {
            reveals.forEach(function(el) { el.classList.add("visible"); });
        }
    })();
</script>

</body>
</html>
