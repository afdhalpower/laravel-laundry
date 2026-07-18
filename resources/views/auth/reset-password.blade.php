@extends("layouts.guest")
@section("title", "Reset Password")
@section("auth_title", "Reset password")
@section("auth_subtitle", "Buat password baru untuk akun Anda.")

@section("content")
<form method="POST" action="{{ route("password.store") }}">
    @csrf
    <input type="hidden" name="token" value="{{ $request->route("token") }}">
    <div class="mb-3">
        <label class="form-label" for="email">Email</label>
        <input id="email" type="email" name="email" class="form-control @error("email") is-invalid @enderror"
            value="{{ old("email", $request->email) }}" required autofocus autocomplete="username">
        @error("email") <div class="invalid-feedback">{{ $message }}</div> @enderror
    </div>
    <div class="mb-3">
        <label class="form-label" for="password">Password Baru</label>
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
    <button type="submit" class="btn btn-brand w-100">Reset Password</button>
</form>
@endsection
