@extends("layouts.guest")
@section("title", "Verifikasi Email")
@section("auth_title", "Verifikasi email")
@section("auth_subtitle", "Terima kasih telah mendaftar! Silakan verifikasi email Anda.")

@section("content")
@if (session("status") == "verification-link-sent")
    <div class="alert alert-success py-2 small mb-3">
        Tautan verifikasi baru telah dikirim ke email Anda.
    </div>
@endif
<p class="text-muted small mb-4">
    Sebelum melanjutkan, periksa email Anda untuk tautan verifikasi. Jika tidak menerima email,
    klik tombol di bawah untuk mengirim ulang.
</p>
<div class="d-flex gap-2">
    <form method="POST" action="{{ route("verification.send") }}">
        @csrf
        <button type="submit" class="btn btn-brand">Kirim Ulang Verifikasi</button>
    </form>
    <form method="POST" action="{{ route("logout") }}">
        @csrf
        <button type="submit" class="btn btn-outline-secondary">Keluar</button>
    </form>
</div>
@endsection
