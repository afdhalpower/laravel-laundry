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
        :root {
            --navy: #1a237e; --navy-dark: #0d1b4a;
            --accent: #42a5f5; --accent-soft: #e3f2fd;
            --ink: #1a1a2e; --muted: #6b7280; --surface: #f8fafc;
            --space-section: 5rem; --ease-out: cubic-bezier(0.16, 1, 0.3, 1);
            --dur-long: 420ms; --dur-short: 220ms;
        }
        * { margin:0; padding:0; box-sizing:border-box; }
        body { font-family:Inter,system-ui,-apple-system,sans-serif; color:var(--ink); background:#fff; line-height:1.6; }

        /* Nav */
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
        .lp-nav .nav-links .btn-wa { background:#25d366; color:#fff!important; border-radius:100px; padding:.4rem 1rem; font-weight:600; font-size:.8rem; }
        .lp-nav .nav-links .btn-wa:hover { background:#1da851; }
        .lp-nav .nav-links .btn-wa::after { display:none; }
        .lp-nav-toggler { display:none; background:none; border:none; font-size:1.5rem; color:var(--navy); cursor:pointer; }

        /* Hero */
        .lp-hero { padding:8rem 0 4rem; background:linear-gradient(165deg,var(--navy) 0%,var(--navy-dark) 100%); color:#fff; position:relative; overflow:hidden; }
        .lp-hero::before { content:""; position:absolute; inset:0; background:radial-gradient(ellipse at 30% 50%, rgba(66,165,245,.15) 0%,transparent 60%),radial-gradient(ellipse at 70% 80%, rgba(66,165,245,.06) 0%,transparent 50%); }
        .lp-hero .container { position:relative; z-index:1; }
        .lp-hero h1 { font-size:clamp(2rem,5vw,3.2rem); font-weight:900; letter-spacing:-.03em; line-height:1.15; max-width:680px; margin-bottom:1rem; }
        .lp-hero h1 span { display:inline-block; }
        .lp-hero p { font-size:1.05rem; color:rgba(255,255,255,.7); max-width:520px; line-height:1.6; margin-bottom:2rem; }
        .lp-hero .btn-primary { background:var(--accent); border:none; border-radius:100px; padding:.75rem 2rem; font-weight:600; font-size:.95rem; }
        .lp-hero .btn-primary:hover { background:#1e88e5; transform:translateY(-1px); }
        .lp-hero .hero-stats { display:flex; gap:3rem; margin-top:3rem; padding-top:2rem; border-top:1px solid rgba(255,255,255,.08); }
        .lp-hero .hero-stat { font-size:.85rem; color:rgba(255,255,255,.5); }
        .lp-hero .hero-stat strong { display:block; font-size:1.5rem; font-weight:800; color:#fff; }

        /* Section */
        section { padding:var(--space-section) 0; }
        .section-label { font-size:.75rem; font-weight:600; text-transform:uppercase; letter-spacing:.1em; color:var(--accent); margin-bottom:1rem; }
        .section-title { font-size:clamp(1.5rem,3vw,2rem); font-weight:800; letter-spacing:-.02em; margin-bottom:.75rem; }
        .section-desc { color:var(--muted); max-width:560px; font-size:.95rem; }

        /* Bento */
        .bento { display:grid; grid-template-columns:1fr 1fr; gap:1.25rem; }
        .bento-card { border-radius:16px; padding:2rem; background:var(--surface); transition:transform var(--dur-short) var(--ease-out),box-shadow var(--dur-short) var(--ease-out); }
        .bento-card:hover { transform:translateY(-4px); box-shadow:0 12px 32px rgba(26,35,126,.08); }
        .bento-card .icon { width:44px; height:44px; border-radius:12px; display:flex; align-items:center; justify-content:center; font-size:1.25rem; margin-bottom:1rem; }
        .bento-card h5 { font-weight:700; font-size:1rem; margin-bottom:.3rem; }
        .bento-card .price { font-size:.85rem; color:var(--navy); font-weight:600; }
        .bento-card p { font-size:.85rem; color:var(--muted); margin-bottom:0; }
        .bento-wide { grid-column:span 2; }
        .bento-stat { background:var(--navy); color:#fff; }
        .bento-stat .stat-num { font-size:2rem; font-weight:900; display:block; }
        .bento-stat .stat-label { font-size:.8rem; color:rgba(255,255,255,.55); }

        /* Testi */
        .testi-card { background:#fff; border:1px solid #eef2f6; border-radius:14px; padding:1.5rem; height:100%; transition:transform var(--dur-short) var(--ease-out); }
        .testi-card:hover { transform:translateY(-3px); box-shadow:0 8px 24px rgba(0,0,0,.04); }
        .testi-card .stars { color:#f59e0b; font-size:.85rem; margin-bottom:.75rem; }
        .testi-card blockquote { font-size:.9rem; color:#374151; line-height:1.6; margin-bottom:1rem; }
        .testi-card .author { display:flex; align-items:center; gap:.75rem; }
        .testi-card .author .avatar { width:40px; height:40px; border-radius:50%; background:var(--accent-soft); color:var(--navy); font-weight:700; font-size:.85rem; display:flex; align-items:center; justify-content:center; }
        .testi-card .author .name { font-weight:600; font-size:.85rem; }

        /* Gallery */
        .gallery-grid { display:grid; grid-template-columns:repeat(auto-fill,minmax(240px,1fr)); gap:1rem; }
        .gallery-item { border-radius:14px; overflow:hidden; position:relative; aspect-ratio:4/3; }
        .gallery-item img { width:100%; height:100%; object-fit:cover; transition:transform .4s var(--ease-out); }
        .gallery-item:hover img { transform:scale(1.06); }
        .gallery-item .caption { position:absolute; bottom:0; left:0; right:0; padding:1rem; background:linear-gradient(transparent,rgba(0,0,0,.6)); color:#fff; font-size:.8rem; font-weight:500; opacity:0; transition:opacity var(--dur-short) var(--ease-out); }
        .gallery-item:hover .caption { opacity:1; }

        /* CTA */
        .lp-cta { background:var(--surface); text-align:center; }
        .lp-cta h2 { font-size:clamp(1.25rem,2.5vw,1.75rem); font-weight:800; }
        .lp-cta .btn-wa-large { display:inline-flex; align-items:center; gap:.5rem; background:#25d366; color:#fff; border:none; border-radius:100px; padding:.85rem 2.5rem; font-weight:700; font-size:1rem; text-decoration:none; transition:background .15s,transform var(--dur-short) var(--ease-out); }
        .lp-cta .btn-wa-large:hover { background:#1da851; transform:translateY(-2px); box-shadow:0 8px 20px rgba(37,211,102,.25); }

        /* Footer */
        .lp-footer { background:var(--navy-dark); color:rgba(255,255,255,.5); font-size:.85rem; padding:2.5rem 0; }
        .lp-footer .container { display:flex; justify-content:space-between; align-items:center; flex-wrap:wrap; gap:1rem; }
        .lp-footer .social a { color:rgba(255,255,255,.4); font-size:1.2rem; margin-left:1rem; transition:color .15s,transform var(--dur-short) var(--ease-out); display:inline-block; }
        .lp-footer .social a:hover { color:#fff; transform:translateY(-2px); }

        /* Floating WA (visible only after scroll) */
        .floating-wa { position:fixed; bottom:1.5rem; right:1.5rem; z-index:1050; width:56px; height:56px; border-radius:50%; background:#25d366; color:#fff; display:flex; align-items:center; justify-content:center; font-size:1.5rem; box-shadow:0 4px 16px rgba(37,211,102,.35); text-decoration:none; transition:opacity .3s,transform .3s; opacity:0; transform:scale(0); pointer-events:none; }
        .floating-wa.show { opacity:1; transform:scale(1); pointer-events:auto; }
        .floating-wa:hover { transform:scale(1.08); box-shadow:0 6px 24px rgba(37,211,102,.45); }

        /* Responsive */
        @media (max-width:768px) {
            .lp-nav .nav-links { display:none; position:absolute; top:64px; left:0; right:0; background:rgba(255,255,255,.98); flex-direction:column; padding:1rem; border-bottom:1px solid #eef2f6; gap:1rem; }
            .lp-nav .nav-links.open { display:flex; }
            .lp-nav-toggler { display:block; }
            .bento { grid-template-columns:1fr; }
            .bento-wide { grid-column:span 1; }
            .lp-hero .hero-stats { gap:1.5rem; flex-wrap:wrap; }
            .lp-footer .container { flex-direction:column; text-align:center; }
            .lp-footer .social a { margin:0 .5rem; }
            .floating-wa { bottom:1rem; right:1rem; width:48px; height:48px; font-size:1.25rem; }
        }
        @media (max-width:480px) {
            :root { --space-section:3rem; }
            .bento-card { padding:1.25rem; }
            .lp-hero { padding:6rem 0 2.5rem; }
        }
    </style>
</head>
<body>

{{-- Nav --}}
<nav class="lp-nav" id="navbar">
    <div class="container">
        <a href="#" class="brand"><i class="bi bi-droplet-half"></i>LaundryKu</a>
        <button class="lp-nav-toggler" id="navToggler" aria-label="Menu"><i class="bi bi-list"></i></button>
        <div class="nav-links" id="navLinks">
            <a href="#layanan">Layanan</a>
            <a href="#tentang">Tentang</a>
            <a href="#testimoni">Testimoni</a>
            <a href="#galeri">Galeri</a>
            <a href="#kontak">Kontak</a>
            <a href="{{ route("cek.status") }}"><i class="bi bi-search me-1"></i>Cek Status</a>
            @if ($settings["whatsapp_number"] ?? null)
                <a href="https://wa.me/{{ $settings["whatsapp_number"] }}" class="btn-wa" target="_blank">
                    <i class="bi bi-whatsapp"></i> {{ $settings["hero_cta_text"] ?? "Pesan" }}
                </a>
            @endif
        </div>
    </div>
</nav>

{{-- Floating WA --}}
@if ($settings["whatsapp_number"] ?? null)
<a href="https://wa.me/{{ $settings["whatsapp_number"] }}" class="floating-wa" id="floatingWa" target="_blank" aria-label="WhatsApp">
    <i class="bi bi-whatsapp"></i>
</a>
@endif

{{-- Hero --}}
<section class="lp-hero">
    <div class="container">
        <h1>{{ $settings["hero_title"] ?? "Laundry Terpercaya di Kota Anda" }}</h1>
        <p>{{ $settings["hero_subtitle"] ?? "Kami siap membantu pakaian Anda bersih, wangi, dan rapi." }}</p>
        @if ($settings["whatsapp_number"] ?? null)
            <a href="https://wa.me/{{ $settings["whatsapp_number"] }}" class="btn btn-primary btn-lg">
                <i class="bi bi-whatsapp me-1"></i> {{ $settings["hero_cta_text"] ?? "Pesan Sekarang" }}
            </a>
        @endif
        <div class="hero-stats">
            <div class="hero-stat"><strong>{{ $services->count() }}</strong> Layanan</div>
            <div class="hero-stat"><strong>{{ $testimonials->count() }}</strong> Testimoni</div>
            <div class="hero-stat"><strong>{{ $galleries->count() }}</strong> Foto</div>
        </div>
    </div>
</section>

{{-- Layanan --}}
<section id="layanan">
    <div class="container">
        <div class="mb-4">
            <div class="section-label">Layanan</div>
            <h2 class="section-title">Harga & Layanan</h2>
            <p class="section-desc">Kami menyediakan berbagai layanan laundry dengan harga terjangkau dan hasil maksimal.</p>
        </div>
        <div class="bento">
            @forelse($services as $s)
                <div class="bento-card">
                    <div class="icon" style="background:var(--accent-soft);color:var(--navy)">
                        <i class="bi bi-{{ $s->tipe == "kiloan" ? "boxes" : "tshirt" }}"></i>
                    </div>
                    <h5>{{ $s->nama }}</h5>
                    <div class="price">Rp {{ number_format($s->harga, 0, ",", ".") }} / {{ $s->tipe == "kiloan" ? "kg" : "pcs" }}</div>
                    <p class="mt-1">{{ $s->estimasi_hari }} hari kerja</p>
                </div>
            @empty
                <div class="bento-card bento-wide text-center text-muted">
                    <i class="bi bi-inbox fs-2 d-block mb-2"></i>
                    <p>Belum ada layanan tersedia.</p>
                </div>
            @endforelse
        </div>
    </div>
</section>

{{-- Tentang --}}
<section id="tentang" style="background:var(--surface);">
    <div class="container">
        <div class="bento">
            <div class="bento-card bento-wide">
                <div class="section-label">Tentang</div>
                <h2 class="section-title">{{ $settings["about_title"] ?? "Tentang LaundryKu" }}</h2>
                <p style="color:var(--muted);font-size:.95rem;line-height:1.7">
                    {{ $settings["about_content"] ?? "LaundryKu adalah jasa laundry profesional yang melayani cuci kering, setrika, dan cuci express." }}
                </p>
            </div>
            <div class="bento-card bento-stat d-flex flex-column justify-content-center">
                <span class="stat-num">{{ $services->filter(fn($s) => $s->tipe == "kiloan")->count() }}</span>
                <span class="stat-label">Layanan Kiloan</span>
            </div>
            <div class="bento-card bento-stat d-flex flex-column justify-content-center" style="background:var(--accent);">
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
        <div class="mb-4">
            <div class="section-label">Testimoni</div>
            <h2 class="section-title">Apa Kata Pelanggan</h2>
            <p class="section-desc">Kepercayaan pelanggan adalah prioritas kami.</p>
        </div>
        <div class="row g-3">
            @foreach($testimonials as $t)
                <div class="col-md-6 col-lg-4">
                    <div class="testi-card">
                        <div class="stars">
                            @for($i=1;$i<=5;$i++)
                                <i class="bi bi-star{{ $i<=$t->rating ? "-fill" : "" }}"></i>
                            @endfor
                        </div>
                        <blockquote>"{{ $t->content }}"</blockquote>
                        <div class="author">
                            <div class="avatar">{{ strtoupper(substr($t->customer_name, 0, 1)) }}</div>
                            <div><div class="name">{{ $t->customer_name }}</div></div>
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
        <div class="mb-4">
            <div class="section-label">Galeri</div>
            <h2 class="section-title">Dokumentasi</h2>
            <p class="section-desc">Hasil kerja dan suasana tempat kami.</p>
        </div>
        <div class="gallery-grid">
            @foreach($galleries as $g)
                <div class="gallery-item">
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

{{-- CTA --}}
<section class="lp-cta" id="kontak">
    <div class="container">
        <h2 class="mb-3">Siap menggunakan layanan kami?</h2>
        <p class="text-muted mb-4">Hubungi kami sekarang dan dapatkan pakaian bersih & wangi.</p>
        @if ($settings["whatsapp_number"] ?? null)
            <a href="https://wa.me/{{ $settings["whatsapp_number"] }}" class="btn-wa-large" target="_blank">
                <i class="bi bi-whatsapp fs-5"></i> {{ $settings["hero_cta_text"] ?? "Pesan Sekarang" }}
            </a>
        @endif
    </div>
</section>

{{-- Map --}}
@if($settings["map_embed_url"] ?? null)
<section style="padding:0;">
    <iframe src="{{ $settings["map_embed_url"] }}" width="100%" height="320" style="border:0;display:block" loading="lazy"></iframe>
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
            @if($settings["facebook_url"] ?? null) <a href="{{ $settings["facebook_url"] }}" target="_blank" aria-label="Facebook"><i class="bi bi-facebook"></i></a> @endif
            @if($settings["instagram_url"] ?? null) <a href="{{ $settings["instagram_url"] }}" target="_blank" aria-label="Instagram"><i class="bi bi-instagram"></i></a> @endif
            @if($settings["whatsapp_number"] ?? null) <a href="https://wa.me/{{ $settings["whatsapp_number"] }}" target="_blank" aria-label="WhatsApp"><i class="bi bi-whatsapp"></i></a> @endif
        </div>
    </div>
</footer>

{{-- Scroll reveal + micro-animations (progressive enhancement — kontep tetap visible walau JS error) --}}
<script>
(function() {
    "use strict";

    // 1. Navbar glass & floating WA
    var nav = document.getElementById("navbar");
    var wa = document.getElementById("floatingWa");
    var ticking = false;
    window.addEventListener("scroll", function() {
        if (!ticking) {
            window.requestAnimationFrame(function() {
                var y = window.scrollY || window.pageYOffset;
                if (nav) nav.classList.toggle("scrolled", y > 80);
                if (wa) wa.classList.toggle("show", y > 300);
                ticking = false;
            });
            ticking = true;
        }
    }, { passive: true });

    // 2. Scroll reveal — IntersectionObserver
    var revealItems = document.querySelectorAll(".bento-card, .testi-card, .gallery-item, section .mb-4");
    if (revealItems.length && !window.matchMedia("(prefers-reduced-motion: reduce)").matches) {
        var observer = new IntersectionObserver(function(entries) {
            entries.forEach(function(entry) {
                if (entry.isIntersecting) {
                    entry.target.style.opacity = "1";
                    entry.target.style.transform = "translateY(0)";
                    observer.unobserve(entry.target);
                }
            });
        }, { threshold: 0.05 });
        revealItems.forEach(function(el) {
            // Set initial state only for items below fold
            var rect = el.getBoundingClientRect();
            if (rect.top > window.innerHeight * 0.8) {
                el.style.opacity = "0";
                el.style.transform = "translateY(20px)";
                el.style.transition = "opacity 0.5s cubic-bezier(0.16,1,0.3,1), transform 0.5s cubic-bezier(0.16,1,0.3,1)";
                observer.observe(el);
            } else {
                el.style.opacity = "1";
                el.style.transform = "translateY(0)";
            }
        });
    }

    // 3. Mobile toggle
    var toggler = document.getElementById("navToggler");
    var navLinks = document.getElementById("navLinks");
    if (toggler && navLinks) {
        toggler.addEventListener("click", function() { navLinks.classList.toggle("open"); });
        navLinks.querySelectorAll("a").forEach(function(l) {
            l.addEventListener("click", function() { navLinks.classList.remove("open"); });
        });
    }

    // 4. Smooth scroll for anchors
    document.querySelectorAll("a[href^='#']").forEach(function(a) {
        a.addEventListener("click", function(e) {
            var id = this.getAttribute("href");
            if (id === "#") return;
            var t = document.querySelector(id);
            if (t) { e.preventDefault(); t.scrollIntoView({ behavior:"smooth", block:"start" }); }
        });
    });
})();
</script>
</body>
</html>