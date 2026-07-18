@extends("layouts.admin")
@section("title", "Edit Pelanggan")
@section("page_title", "Edit Pelanggan")

@section("content")
<div class="row justify-content-center">
    <div class="col-md-6">
        <div class="card">
            <div class="card-header">
                <i class="bi bi-person me-1"></i> Form Edit Pelanggan
            </div>
            <div class="card-body">
                <form action="{{ route("customers.update", $customer) }}" method="POST">
                    @csrf @method("PUT")
                    <div class="mb-3">
                        <label class="form-label">Nama Lengkap <span class="text-danger">*</span></label>
                        <input type="text" name="nama" class="form-control @error("nama") is-invalid @enderror" value="{{ old("nama", $customer->nama) }}" required>
                        @error("nama") <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                    <div class="mb-3">
                        <label class="form-label">No. Telepon <span class="text-danger">*</span></label>
                        <input type="text" name="no_telp" class="form-control @error("no_telp") is-invalid @enderror" value="{{ old("no_telp", $customer->no_telp) }}" required>
                        @error("no_telp") <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Alamat</label>
                        <textarea name="alamat" class="form-control @error("alamat") is-invalid @enderror" rows="3">{{ old("alamat", $customer->alamat) }}</textarea>
                        @error("alamat") <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                    <div class="d-flex gap-2">
                        <button type="submit" class="btn btn-primary">
                            <i class="bi bi-save"></i> Update
                        </button>
                        <a href="{{ route("customers.index") }}" class="btn btn-outline-secondary">Batal</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
