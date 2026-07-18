@extends("layouts.admin")
@section("title", "Edit Layanan")
@section("page_title", "Edit Layanan")

@section("content")
<div class="row justify-content-center">
    <div class="col-md-6">
        <div class="card">
            <div class="card-header"><i class="bi bi-gear me-1"></i> Form Edit Layanan</div>
            <div class="card-body">
                <form action="{{ route("services.update", $service) }}" method="POST">
                    @csrf @method("PUT")
                    <div class="mb-3">
                        <label class="form-label">Nama Layanan <span class="text-danger">*</span></label>
                        <input type="text" name="nama" class="form-control @error("nama") is-invalid @enderror" value="{{ old("nama", $service->nama) }}" required>
                        @error("nama") <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Tipe <span class="text-danger">*</span></label>
                        <select name="tipe" class="form-select @error("tipe") is-invalid @enderror" required>
                            <option value="kiloan" {{ old("tipe", $service->tipe) == "kiloan" ? "selected" : "" }}>Kiloan (per kg)</option>
                            <option value="satuan" {{ old("tipe", $service->tipe) == "satuan" ? "selected" : "" }}>Satuan (per item)</option>
                        </select>
                        @error("tipe") <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Harga <span class="text-danger">*</span></label>
                        <div class="input-group">
                            <span class="input-group-text">Rp</span>
                            <input type="number" name="harga" class="form-control @error("harga") is-invalid @enderror" value="{{ old("harga", $service->harga) }}" required min="0" step="500">
                            @error("harga") <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Estimasi Pengerjaan</label>
                        <div class="input-group">
                            <input type="number" name="estimasi_hari" class="form-control @error("estimasi_hari") is-invalid @enderror" value="{{ old("estimasi_hari", $service->estimasi_hari) }}" min="1">
                            <span class="input-group-text">hari</span>
                        </div>
                    </div>
                    <div class="d-flex gap-2">
                        <button type="submit" class="btn btn-primary"><i class="bi bi-save"></i> Update</button>
                        <a href="{{ route("services.index") }}" class="btn btn-outline-secondary">Batal</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
