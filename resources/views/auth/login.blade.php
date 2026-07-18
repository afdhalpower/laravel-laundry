@extends("layouts.guest")
@section("title", "Masuk")
@section("auth_title", "Selamat datang kembali")
@section("auth_subtitle", "Masuk ke akun LaundryKu Anda")

@section("content")
<form method="POST" action="{{ route("login") }}">
    @csrf
    <div class="mb-3">
        <label class="form-label" for="email">Email</label>
        <input id="email" type="email" name="email" class="form-control @error("email") is-invalid @enderror"
            value="{{ old("email") }}" required autofocus autocomplete="username">
        @error("email") <div class="invalid-feedback">{{ $message }}</div> @enderror
    </div>
    <div class="mb-3">
        <label class="form-label" for="password">Password</label>
        <input id="password" type="password" name="password"
            class="form-control @error("password") is-invalid @enderror"
            required autocomplete="current-password">
        @error("password") <div class="invalid-feedback">{{ $message }}</div> @enderror
    </div>
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div class="form-check">
            <input id="remember_me" type="checkbox" name="remember" class="form-check-input">
            <label class="form-check-label small" for="remember_me">Ingat saya</label>
        </div>
        @if (Route::has("password.request"))
            <a href="{{ route("password.request") }}" class="auth-link small">Lupa password?</a>
        @endif
    </div>
    <button type="submit" class="btn btn-brand w-100 mb-3">Masuk</button>
    @if (Route::has("register"))
        <p class="text-center small text-muted mb-0">
            Belum punya akun?
            <a href="{{ route("register") }}" class="auth-link">Daftar</a>
        </p>
    @endif
</form>
@endsection
