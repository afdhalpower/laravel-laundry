@extends("layouts.admin")
@section("title", "Profil")
@section("page_title", "Pengaturan Profil")

@section("content")
<div class="row">
    <div class="col-lg-8">
        {{-- Informasi Profil --}}
        <div class="card mb-4">
            <div class="card-header">
                <i class="bi bi-person me-1"></i> Informasi Profil
            </div>
            <div class="card-body">
                <p class="text-muted small mb-4">Perbarui informasi profil dan email akun Anda.</p>

                <form method="post" action="{{ route("profile.update") }}" class="mb-0">
                    @csrf
                    @method("patch")

                    <div class="mb-3">
                        <label for="name" class="form-label">Nama</label>
                        <input id="name" name="name" type="text"
                            class="form-control @error("name", "updateProfileInformation") is-invalid @enderror"
                            value="{{ old("name", $user->name) }}" required autofocus autocomplete="name">
                        @error("name", "updateProfileInformation")
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="email" class="form-label">Email</label>
                        <input id="email" name="email" type="email"
                            class="form-control @error("email", "updateProfileInformation") is-invalid @enderror"
                            value="{{ old("email", $user->email) }}" required autocomplete="username">
                        @error("email", "updateProfileInformation")
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="d-flex align-items-center gap-2">
                        <button type="submit" class="btn btn-primary">
                            <i class="bi bi-save me-1"></i> Simpan
                        </button>
                        @if (session("status") === "profile-updated")
                            <span class="text-success small">
                                <i class="bi bi-check-circle"></i> Tersimpan.
                            </span>
                        @endif
                    </div>
                </form>
            </div>
        </div>

        {{-- Update Password --}}
        <div class="card mb-4">
            <div class="card-header">
                <i class="bi bi-shield-lock me-1"></i> Ganti Password
            </div>
            <div class="card-body">
                <p class="text-muted small mb-4">Pastikan akun Anda menggunakan password yang panjang dan acak untuk keamanan.</p>

                <form method="post" action="{{ route("password.update") }}" class="mb-0">
                    @csrf
                    @method("put")

                    <div class="mb-3">
                        <label for="current_password" class="form-label">Password Saat Ini</label>
                        <input id="current_password" name="current_password" type="password"
                            class="form-control @error("current_password", "updatePassword") is-invalid @enderror"
                            autocomplete="current-password">
                        @error("current_password", "updatePassword")
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="password" class="form-label">Password Baru</label>
                        <input id="password" name="password" type="password"
                            class="form-control @error("password", "updatePassword") is-invalid @enderror"
                            autocomplete="new-password">
                        @error("password", "updatePassword")
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="password_confirmation" class="form-label">Konfirmasi Password</label>
                        <input id="password_confirmation" name="password_confirmation" type="password"
                            class="form-control @error("password_confirmation", "updatePassword") is-invalid @enderror"
                            autocomplete="new-password">
                        @error("password_confirmation", "updatePassword")
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="d-flex align-items-center gap-2">
                        <button type="submit" class="btn btn-primary">
                            <i class="bi bi-save me-1"></i> Simpan
                        </button>
                        @if (session("status") === "password-updated")
                            <span class="text-success small">
                                <i class="bi bi-check-circle"></i> Tersimpan.
                            </span>
                        @endif
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="col-lg-4">
        {{-- Informasi Akun --}}
        <div class="card mb-4">
            <div class="card-header">
                <i class="bi bi-info-circle me-1"></i> Info Akun
            </div>
            <div class="card-body text-center">
                <div class="rounded-circle bg-primary text-white d-flex align-items-center justify-content-center mx-auto mb-3"
                    style="width:80px;height:80px;font-size:2rem;font-weight:700">
                    {{ strtoupper(substr($user->name, 0, 1)) }}
                </div>
                <h5 class="fw-semibold mb-0">{{ $user->name }}</h5>
                <small class="text-muted">{{ $user->email }}</small>
                <hr>
                <div class="text-start small">
                    <div class="d-flex justify-content-between mb-1">
                        <span class="text-muted">Bergabung</span>
                        <span>{{ $user->created_at->format("d/m/Y") }}</span>
                    </div>
                </div>
            </div>
        </div>

        {{-- Hapus Akun --}}
        <div class="card border-danger">
            <div class="card-header text-danger">
                <i class="bi bi-exclamation-triangle me-1"></i> Hapus Akun
            </div>
            <div class="card-body">
                <p class="small text-muted mb-3">
                    Setelah akun dihapus, semua data akan terhapus permanen. Pastikan Anda sudah menyimpan data penting.
                </p>
                <button type="button" class="btn btn-outline-danger w-100" data-bs-toggle="modal" data-bs-target="#deleteModal">
                    <i class="bi bi-trash me-1"></i> Hapus Akun
                </button>
            </div>
        </div>
    </div>
</div>

{{-- Modal Hapus Akun --}}
<div class="modal fade" id="deleteModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <form method="post" action="{{ route("profile.destroy") }}">
                @csrf
                @method("delete")
                <div class="modal-header">
                    <h5 class="modal-title">Hapus Akun</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <p class="small text-muted mb-3">
                        Yakin ingin menghapus akun? Semua data akan terhapus permanen.
                        Masukkan password Anda untuk konfirmasi.
                    </p>
                    <div class="mb-0">
                        <input type="password" name="password" class="form-control @error("password", "userDeletion") is-invalid @enderror"
                            placeholder="Password">
                        @error("password", "userDeletion")
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-danger">Hapus Akun</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
