<!DOCTYPE html>
<html lang="id" data-bs-theme="light">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield("title", "Laundry App") - {{ config("app.name") }}</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    @stack("styles")
    <style>
        :root { --font-sans: "Inter", system-ui, -apple-system, sans-serif; }
        [data-bs-theme="dark"] {
            --navy: #3949ab;
            --sidebar-bg: #1a1a2e;
            --sidebar-hover: rgba(255,255,255,0.08);
            --body-bg: #121212;
            --card-bg: #1e1e1e;
            --card-border: #2d2d2d;
            --text-primary: #e0e0e0;
            --text-muted: #9e9e9e;
            --heading-color: #e0e0e0;
            --topbar-bg: #1a1a2e;
            --topbar-border: #2d2d2d;
            --table-header-bg: #252525;
            --table-border: #2d2d2d;
            --input-bg: #2d2d2d;
            --input-border: #404040;
            --input-color: #e0e0e0;
        }
        [data-bs-theme="dark"] body { background-color: var(--body-bg); color: var(--text-primary); }
        [data-bs-theme="dark"] .topbar { background: var(--topbar-bg); border-color: var(--topbar-border); }
        [data-bs-theme="dark"] .topbar h5 { color: #90caf9; }
        [data-bs-theme="dark"] .content-wrapper { color: var(--text-primary); }
        [data-bs-theme="dark"] .stat-card { background: var(--card-bg); border-color: var(--card-border); }
        [data-bs-theme="dark"] .stat-card .value { color: #90caf9; }
        [data-bs-theme="dark"] .stat-card .label { color: var(--text-muted); }
        [data-bs-theme="dark"] .page-title { color: #90caf9; }
        [data-bs-theme="dark"] .card { background: var(--card-bg); border-color: var(--card-border); }
        [data-bs-theme="dark"] .card-header { background: var(--card-bg); border-color: var(--card-border); color: var(--text-primary); }
        [data-bs-theme="dark"] .table { color: var(--text-primary); }
        [data-bs-theme="dark"] .table th { background: var(--table-header-bg); color: var(--text-muted); border-color: var(--table-border); }
        [data-bs-theme="dark"] .table td { border-color: var(--table-border); }
        [data-bs-theme="dark"] .table-hover tbody tr:hover { background: rgba(255,255,255,0.03); }
        [data-bs-theme="dark"] .table-active { background: rgba(255,255,255,0.05) !important; }
        [data-bs-theme="dark"] .bg-light { background-color: #2d2d2d !important; }
        [data-bs-theme="dark"] .text-muted { color: var(--text-muted) !important; }
        [data-bs-theme="dark"] .btn-outline-secondary { color: var(--text-muted); border-color: #404040; }
        [data-bs-theme="dark"] .btn-outline-secondary:hover { background: #404040; color: #fff; }
        [data-bs-theme="dark"] .form-control, [data-bs-theme="dark"] .form-select {
            background: var(--input-bg); border-color: var(--input-border); color: var(--input-color);
        }
        [data-bs-theme="dark"] .form-control:focus, [data-bs-theme="dark"] .form-select:focus {
            background: var(--input-bg); color: var(--input-color);
        }
        [data-bs-theme="dark"] .input-group-text {
            background: #2d2d2d; border-color: var(--input-border); color: var(--text-muted);
        }
        [data-bs-theme="dark"] .alert-success { background: #1b4332; border-color: #2d6a4f; color: #95d5b2; }
        [data-bs-theme="dark"] .alert-danger { background: #4a1a1a; border-color: #7a1a1a; color: #f5a5a5; }
        [data-bs-theme="dark"] .btn-primary { background-color: #3949ab; border-color: #3949ab; }
        [data-bs-theme="dark"] .btn-primary:hover { background-color: #5c6bc0; border-color: #5c6bc0; }
        [data-bs-theme="dark"] .btn-outline-primary { color: #7986cb; border-color: #7986cb; }
        [data-bs-theme="dark"] .btn-outline-primary:hover { background-color: #3949ab; border-color: #3949ab; color: #fff; }
        [data-bs-theme="dark"] .pagination .page-link { background: var(--card-bg); border-color: var(--card-border); color: var(--text-primary); }
        [data-bs-theme="dark"] .pagination .page-item.active .page-link { background: #3949ab; border-color: #3949ab; }
        [data-bs-theme="dark"] .page-item.disabled .page-link { background: var(--card-bg); color: var(--text-muted); }
        [data-bs-theme="dark"] .border-bottom { border-color: var(--card-border) !important; }
        [data-bs-theme="dark"] hr { border-color: var(--card-border); }
        [data-bs-theme="dark"] .modal-content { background: var(--card-bg); color: var(--text-primary); border-color: var(--card-border); }
        [data-bs-theme="dark"] .modal-header { border-color: var(--card-border); }
        body { font-family: var(--font-sans); background-color: #f5f7fa; }
        .sidebar {
            position: fixed; top: 0; left: 0; bottom: 0; width: 250px;
            background: linear-gradient(180deg, #1a237e 0%, #283593 100%);
            padding-top: 1rem; overflow-y: auto; z-index: 1000;
        }
        .sidebar-brand {
            padding: 1rem 1.25rem; color: #fff; font-weight: 700; font-size: 1.25rem;
            display: flex; align-items: center; gap: 0.75rem;
            border-bottom: 1px solid rgba(255,255,255,0.1); margin-bottom: 0.5rem;
        }
        .sidebar-brand i { font-size: 1.5rem; color: #90caf9; }
        .sidebar .nav-link {
            color: rgba(255,255,255,0.75); padding: 0.625rem 1.25rem;
            display: flex; align-items: center; gap: 0.75rem;
            font-size: 0.9rem; transition: all 0.2s;
        }
        .sidebar .nav-link:hover { color: #fff; background: rgba(255,255,255,0.1); }
        .sidebar .nav-link.active { color: #fff; background: rgba(255,255,255,0.15); border-right: 3px solid #64b5f6; }
        .sidebar .nav-link i { font-size: 1.1rem; width: 1.25rem; text-align: center; }
        .sidebar .nav-section {
            color: rgba(255,255,255,0.4); font-size: 0.7rem; text-transform: uppercase;
            letter-spacing: 0.08em; padding: 1rem 1.25rem 0.35rem; font-weight: 600;
        }
        .main-content { margin-left: 250px; min-height: 100vh; }
        .topbar {
            background: #fff; border-bottom: 1px solid #e9ecef;
            padding: 0.75rem 1.5rem; display: flex; align-items: center;
            justify-content: space-between; position: sticky; top: 0; z-index: 999;
        }
        .topbar h5 { margin: 0; font-weight: 600; color: #1a237e; }
        .content-wrapper { padding: 1.5rem; }
        .stat-card {
            background: #fff; border-radius: 12px; padding: 1.25rem;
            border: 1px solid #e9ecef; transition: transform 0.2s;
        }
        .stat-card:hover { transform: translateY(-2px); }
        .stat-card .icon { width: 48px; height: 48px; border-radius: 12px; display: flex; align-items: center; justify-content: center; font-size: 1.5rem; }
        .stat-card .value { font-size: 1.75rem; font-weight: 700; color: #1a237e; }
        .stat-card .label { font-size: 0.85rem; color: #6c757d; }
        .page-title { font-weight: 600; color: #1a237e; margin-bottom: 1.5rem; display: flex; align-items: center; justify-content: space-between; }
        .table th { font-weight: 600; font-size: 0.85rem; color: #495057; border-top: none; background: #f8f9fa; }
        .btn-primary { background-color: #1a237e; border-color: #1a237e; }
        .btn-primary:hover { background-color: #283593; border-color: #283593; }
        .btn-outline-primary { color: #1a237e; border-color: #1a237e; }
        .btn-outline-primary:hover { background-color: #1a237e; border-color: #1a237e; }
        .badge-status { font-size: 0.8rem; padding: 0.35em 0.65em; }
        .card { border-radius: 12px; border: 1px solid #e9ecef; }
        .card-header { background: #fff; border-bottom: 1px solid #e9ecef; font-weight: 600; padding: 1rem 1.25rem; }
        .table > :not(caption) > * > * { vertical-align: middle; }
        .footer-note { text-align: center; padding: 1.5rem; color: #adb5bd; font-size: 0.85rem; }
        @media (max-width: 768px) {
            .sidebar { transform: translateX(-100%); transition: transform 0.3s; }
            .sidebar.show { transform: translateX(0); }
            .main-content { margin-left: 0; }
        }
    </style>
</head>
<body>
    <nav class="sidebar" id="sidebar">
        <div class="sidebar-brand">
            <i class="bi bi-droplet-half"></i>
            LaundryKu
        </div>
        <div class="nav-section">Menu Utama</div>
        <a href="{{ route("dashboard") }}" class="nav-link {{ request()->routeIs("dashboard") ? "active" : "" }}">
            <i class="bi bi-speedometer2"></i> Dashboard
        </a>
        @if(auth()->user()->isAdmin() || auth()->user()->isKasir())
        <a href="{{ route("orders.index") }}" class="nav-link {{ request()->routeIs("orders.*") ? "active" : "" }}">
            <i class="bi bi-receipt"></i> Transaksi
        </a>
        <a href="{{ route("customers.index") }}" class="nav-link {{ request()->routeIs("customers.*") ? "active" : "" }}">
            <i class="bi bi-people"></i> Pelanggan
        </a>
        @endif

        @if(auth()->user()->isAdmin())
        <a href="{{ route("services.index") }}" class="nav-link {{ request()->routeIs("services.*") ? "active" : "" }}">
            <i class="bi bi-gear"></i> Layanan
        </a>
        @endif

        @if(auth()->user()->isAdmin() || auth()->user()->isOwner())
        <a href="{{ route("reports") }}" class="nav-link {{ request()->routeIs("reports") ? "active" : "" }}">
            <i class="bi bi-bar-chart"></i> Laporan
        </a>
        @endif

        @if(auth()->user()->isAdmin())
        @can("expenses-access")
        <a href="{{ route("expenses.index") }}" class="nav-link {{ request()->routeIs("expenses.*") ? "active" : "" }}">
            <i class="bi bi-cash-stack"></i> Pengeluaran
        </a>
        @endcan
        @can("packages-access")
        <a href="{{ route("packages.index") }}" class="nav-link {{ request()->routeIs("packages.*") ? "active" : "" }}">
            <i class="bi bi-box-seam"></i> Paket
        </a>
        @endcan
        @endif

        <div class="nav-section mt-3">Halaman Depan</div>
        <div class="nav-section">
            <a href="{{ route("expenses.index") }}" class="nav-link \{{ request()->routeIs("expenses.*") ? "active" : "" }}">
                <i class="bi bi-receipt"></i> Pengeluaran
            </a>
            <a href="{{ route("packages.index") }}" class="nav-link \{{ request()->routeIs("packages.*") ? "active" : "" }}">
                <i class="bi bi-box"></i> Paket
            </a>
        </div>
        @if(auth()->user()->isAdmin())
        <a href="{{ route("admin.landing-settings.index") }}" class="nav-link {{ request()->routeIs("admin.landing-settings.*") ? "active" : "" }}">
            <i class="bi bi-sliders"></i> Pengaturan
        </a>
        <a href="{{ route("admin.testimonials.index") }}" class="nav-link {{ request()->routeIs("admin.testimonials.*") ? "active" : "" }}">
            <i class="bi bi-star"></i> Testimoni
        </a>
        <a href="{{ route("admin.galleries.index") }}" class="nav-link {{ request()->routeIs("admin.galleries.*") ? "active" : "" }}">
            <i class="bi bi-images"></i> Galeri
        </a>
        @endif

        @if(auth()->user()->isAdmin() || auth()->user()->isOwner())
        <a href="{{ route("activity-logs.index") }}" class="nav-link {{ request()->routeIs("activity-logs.*") ? "active" : "" }}">
            <i class="bi bi-clock-history"></i> Activity Log
        </a>
        @endif
        <div class="nav-section mt-3">Akun</div>
        <a href="{{ route("profile.edit") }}" class="nav-link">
            <i class="bi bi-person"></i> Profil
        </a>
        <form method="POST" action="{{ route("logout") }}" class="d-inline">
            @csrf
            <button type="submit" class="nav-link w-100 text-start" style="background:none;border:none;cursor:pointer">
                <i class="bi bi-box-arrow-right"></i> Keluar
            </button>
        </form>
        <div class="mt-auto p-3" style="border-top:1px solid rgba(255,255,255,0.1)">
            <small style="color:rgba(255,255,255,0.4);font-size:0.75rem">&copy; {{ date("Y") }} LaundryKu</small>
        </div>
    </nav>

    <div class="main-content">
        <div class="topbar">
            <button class="btn btn-sm btn-outline-secondary d-md-none" onclick="document.getElementById("sidebar").classList.toggle("show")">
                <i class="bi bi-list"></i>
            </button>
            <h5>@yield("page_title", "Dashboard")</h5>
            <div class="d-flex align-items-center gap-2">
                <button id="darkModeToggle" class="btn btn-sm btn-outline-secondary" title="Toggle Dark Mode"
                    onclick="toggleDarkMode()">
                    <i id="darkModeIcon" class="bi bi-moon-stars"></i>
                </button>
                <span class="text-muted small">{{ auth()->user()->name ?? "Admin" }}</span>
                <span class="badge bg-primary me-2">{{ auth()->user()->role ?? "admin" }}</span>
                <div class="rounded-circle bg-primary text-white d-flex align-items-center justify-content-center" style="width:36px;height:36px;font-weight:600;font-size:0.9rem">
                    {{ strtoupper(substr(auth()->user()->name ?? "A", 0, 1)) }}
                </div>
            </div>
        </div>
        <div class="content-wrapper">
            @if(session("success"))
                <div class="alert alert-success alert-dismissible fade show">
                    <i class="bi bi-check-circle me-1"></i> {{ session("success") }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif
            @if(session("error"))
                <div class="alert alert-danger alert-dismissible fade show">
                    <i class="bi bi-exclamation-triangle me-1"></i> {{ session("error") }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif
            @yield("content")
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        (function() {
            var theme = localStorage.getItem("theme") || "light";
            document.documentElement.setAttribute("data-bs-theme", theme);
            var icon = document.getElementById("darkModeIcon");
            if (icon) icon.className = theme === "dark" ? "bi bi-sun" : "bi bi-moon-stars";
        })();
        function toggleDarkMode() {
            var html = document.documentElement;
            var current = html.getAttribute("data-bs-theme");
            var next = current === "dark" ? "light" : "dark";
            html.setAttribute("data-bs-theme", next);
            localStorage.setItem("theme", next);
            var icon = document.getElementById("darkModeIcon");
            if (icon) icon.className = next === "dark" ? "bi bi-sun" : "bi bi-moon-stars";
        }
    </script>

    <script>
        // Prevent double form submission
        document.addEventListener("DOMContentLoaded", function() {
            document.querySelectorAll("form").forEach(function(form) {
                form.addEventListener("submit", function(e) {
                    var btn = form.querySelector("button[type=submit]");
                    if (btn) {
                        btn.disabled = true;
                        btn.innerHTML = '<span class="spinner-border spinner-border-sm" role="status"></span> Loading...';
                    }
                });
            });
        });
    </script>
    @stack("scripts")
</body>
</html>