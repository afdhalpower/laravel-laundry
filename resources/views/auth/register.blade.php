@extends("layouts.guest")
@section("title", "Daftar")
@section("auth_title", "Buat akun baru")
@section("auth_subtitle", "Daftar untuk mulai menggunakan LaundryKu")

@section("content")
<form method="POST" action="{{ route("register") }}">
    @csrf
    <div class="mb-3">
        <label class="form-label" for="name">Nama</label>
        <input id="name" type="text" name="name" class="form-control @error("name") is-invalid @enderror"
            value="{{ old("name") }}" required autofocus autocomplete="name">
        @error("name") <div class="invalid-feedback">{{ $message }}</div> @enderror
    </div>
    <div class="mb-3">
        <label class="form-label" for="email">Email</label>
        <input id="email" type="email" name="email" class="form-control @error("email") is-invalid @enderror"
            value="{{ old("email") }}" required autocomplete="username">
        @error("email") <div class="invalid-feedback">{{ $message }}</div> @enderror
    </div>
    <div class="mb-3">
        <label class="form-label" for="password">Password</label>
        <input id="password" type="password" name="password"
            class="form-control @error("password") is-invalid @enderror"
            required autocomplete="new-password">
        @error("password") <div class="invalid-feedback">{{ $message }}</div> @enderror
    </div>
    <div class="mb-4">
        <label class="form-label" for="password_confirmation">Konfirmasi Password</label>
        <input id="password_confirmation" type="password" name="password_confirmation"
            class="form-control @error("password_confirmation") is-invalid @enderror"
            required autocomplete="new-password">
        @error("password_confirmation") <div class="invalid-feedback">{{ $message }}</div> @enderror
    </div>
    <button type="submit" class="btn btn-brand w-100 mb-3">Daftar</button>
    <p class="text-center small text-muted mb-0">
        Sudah punya akun?
        <a href="{{ route("login") }}" class="auth-link">Masuk</a>
    </p>
</form>
@endsection
