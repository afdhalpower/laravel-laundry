<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield("title", "Masuk") - {{ config("app.name", "LaundryKu") }}</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">

    <style>
        :root { --brand: #1a237e; --brand-light: #283593; --surface: #f5f7fa; }
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body {
            font-family: "Inter", system-ui, -apple-system, sans-serif;
            background: var(--surface); min-height: 100vh;
            display: flex; align-items: center; justify-content: center; padding: 1.5rem;
        }
        .auth-wrapper {
            display: flex; width: 100%; max-width: 920px; min-height: 580px;
            border-radius: 20px; background: #fff;
            box-shadow: 0 12px 40px rgba(0,0,0,0.06); overflow: hidden;
        }
        .auth-side {
            width: 380px; background: linear-gradient(165deg, var(--brand) 0%, #0d1b4a 100%);
            padding: 3rem 2rem; display: flex; flex-direction: column;
            justify-content: center; color: #fff; flex-shrink: 0;
        }
        .auth-side .brand-icon { font-size: 2.5rem; color: #90caf9; margin-bottom: 1rem; }
        .auth-side h2 { font-weight: 700; font-size: 1.5rem; margin-bottom: 0.5rem; letter-spacing: -0.02em; }
        .auth-side p { font-size: 0.875rem; color: rgba(255,255,255,0.7); line-height: 1.5; }
        .auth-side .features { margin-top: 2rem; display: flex; flex-direction: column; gap: 0.75rem; }
        .auth-side .feature-item { display: flex; align-items: center; gap: 0.625rem; font-size: 0.8rem; color: rgba(255,255,255,0.65); }
        .auth-side .feature-item i { font-size: 0.9rem; color: #64b5f6; }
        .auth-main { flex: 1; padding: 3rem 2.5rem; display: flex; flex-direction: column; justify-content: center; }
        .auth-main .auth-header { margin-bottom: 1.75rem; }
        .auth-main .auth-header h4 { font-weight: 700; color: #1a1a2e; font-size: 1.25rem; margin-bottom: 0.25rem; }
        .auth-main .auth-header p { font-size: 0.85rem; color: #6b7280; }
        .form-label { font-weight: 500; font-size: 0.85rem; color: #374151; margin-bottom: 0.35rem; }
        .form-control, .form-select {
            border: 1.5px solid #e2e8f0; border-radius: 10px; padding: 0.6rem 0.875rem;
            font-size: 0.9rem; transition: border-color 0.2s, box-shadow 0.2s;
        }
        .form-control:focus, .form-select:focus { border-color: var(--brand); box-shadow: 0 0 0 3px rgba(26,35,126,0.1); }
        .form-control.is-invalid { border-color: #dc3545; box-shadow: 0 0 0 3px rgba(220,53,69,0.08); }
        .btn-brand { background: var(--brand); border: none; border-radius: 10px; padding: 0.625rem 1.5rem; font-weight: 600; font-size: 0.9rem; color: #fff; }
        .btn-brand:hover { background: var(--brand-light); }
        .btn-brand:focus-visible { outline: 2px solid var(--brand); outline-offset: 2px; }
        .auth-link { color: var(--brand); font-size: 0.85rem; text-decoration: none; font-weight: 500; }
        .auth-link:hover { text-decoration: underline; }
        .invalid-feedback { font-size: 0.8rem; }
        @media (max-width: 768px) { .auth-side { display: none; } .auth-wrapper { max-width: 440px; } .auth-main { padding: 2rem 1.5rem; } }
        @media (max-width: 480px) { body { padding: 0.75rem; } .auth-wrapper { border-radius: 16px; } .auth-main { padding: 1.5rem 1.25rem; } }
    </style>
    @stack("styles")
</head>
<body>
    <div class="auth-wrapper">
        <div class="auth-side">
            <div class="brand-icon"><i class="bi bi-droplet-half"></i></div>
            <h2>LaundryKu</h2>
            <p>Kelola usaha laundry dengan mudah, cepat, dan profesional.</p>
            <div class="features">
                <div class="feature-item"><i class="bi bi-check2"></i><span>Manajemen pelanggan & layanan</span></div>
                <div class="feature-item"><i class="bi bi-check2"></i><span>Tracking status order real-time</span></div>
                <div class="feature-item"><i class="bi bi-check2"></i><span>Laporan pendapatan & grafik</span></div>
            </div>
        </div>
        <div class="auth-main">
            <div class="auth-header">
                @hasSection("auth_title")
                    <h4>@yield("auth_title")</h4>
                    <p>@yield("auth_subtitle")</p>
                @endif
            </div>
            @if(session("status"))
                <div class="alert alert-success py-2 small mb-3">{{ session("status") }}</div>
            @endif
            @yield("content")
        </div>
    </div>
</body>
</html>
