@extends("layouts.admin")
@section("title", "Tambah Pelanggan")
@section("page_title", "Tambah Pelanggan")

@section("content")
<div class="row justify-content-center">
    <div class="col-md-6">
        <div class="card">
            <div class="card-header">
                <i class="bi bi-person-plus me-1"></i> Form Pelanggan Baru
            </div>
            <div class="card-body">
                <form action="{{ route("customers.store") }}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label class="form-label">Nama Lengkap <span class="text-danger">*</span></label>
                        <input type="text" name="nama" class="form-control @error("nama") is-invalid @enderror" value="{{ old("nama") }}" required>
                        @error("nama") <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                    <div class="mb-3">
                        <label class="form-label">No. Telepon <span class="text-danger">*</span></label>
                        <input type="text" name="no_telp" class="form-control @error("no_telp") is-invalid @enderror" value="{{ old("no_telp") }}" required placeholder="08xxxxxxxxxx">
                        @error("no_telp") <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Alamat</label>
                        <textarea name="alamat" class="form-control @error("alamat") is-invalid @enderror" rows="3">{{ old("alamat") }}</textarea>
                        @error("alamat") <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                    <div class="d-flex gap-2">
                        <button type="submit" class="btn btn-primary">
                            <i class="bi bi-save"></i> Simpan
                        </button>
                        <a href="{{ route("customers.index") }}" class="btn btn-outline-secondary">Batal</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
