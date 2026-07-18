@extends("layouts.admin")
@section("title", "Tambah Layanan")
@section("page_title", "Tambah Layanan")

@section("content")
<div class="row justify-content-center">
    <div class="col-md-6">
        <div class="card">
            <div class="card-header"><i class="bi bi-plus-circle me-1"></i> Form Layanan Baru</div>
            <div class="card-body">
                <form action="{{ route("services.store") }}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label class="form-label">Nama Layanan <span class="text-danger">*</span></label>
                        <input type="text" name="nama" class="form-control @error("nama") is-invalid @enderror" value="{{ old("nama") }}" required>
                        @error("nama") <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Tipe <span class="text-danger">*</span></label>
                        <select name="tipe" class="form-select @error("tipe") is-invalid @enderror" required>
                            <option value="">-- Pilih Tipe --</option>
                            <option value="kiloan" {{ old("tipe") == "kiloan" ? "selected" : "" }}>Kiloan (per kg)</option>
                            <option value="satuan" {{ old("tipe") == "satuan" ? "selected" : "" }}>Satuan (per item)</option>
                        </select>
                        @error("tipe") <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Harga <span class="text-danger">*</span></label>
                        <div class="input-group">
                            <span class="input-group-text">Rp</span>
                            <input type="number" name="harga" class="form-control @error("harga") is-invalid @enderror" value="{{ old("harga") }}" required min="0" step="500">
                            @error("harga") <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Estimasi Pengerjaan</label>
                        <div class="input-group">
                            <input type="number" name="estimasi_hari" class="form-control @error("estimasi_hari") is-invalid @enderror" value="{{ old("estimasi_hari", 2) }}" min="1">
                            <span class="input-group-text">hari</span>
                            @error("estimasi_hari") <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                    </div>
                    <div class="d-flex gap-2">
                        <button type="submit" class="btn btn-primary"><i class="bi bi-save"></i> Simpan</button>
                        <a href="{{ route("services.index") }}" class="btn btn-outline-secondary">Batal</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
