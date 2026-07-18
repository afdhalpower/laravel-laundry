@extends("layouts.guest")
@section("title", "Lupa Password")
@section("auth_title", "Lupa password?")
@section("auth_subtitle", "Masukkan email Anda dan kami akan kirim tautan reset.")

@section("content")
<form method="POST" action="{{ route("password.email") }}">
    @csrf
    <div class="mb-4">
        <label class="form-label" for="email">Email</label>
        <input id="email" type="email" name="email" class="form-control @error("email") is-invalid @enderror"
            value="{{ old("email") }}" required autofocus>
        @error("email") <div class="invalid-feedback">{{ $message }}</div> @enderror
    </div>
    <button type="submit" class="btn btn-brand w-100 mb-3">Kirim Tautan Reset</button>
    <p class="text-center small text-muted mb-0">
        <a href="{{ route("login") }}" class="auth-link">Kembali ke halaman masuk</a>
    </p>
</form>
@endsection
