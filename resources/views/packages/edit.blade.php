@extends("layouts.admin")
@section("title", "Edit Paket")
@section("page_title", "Edit Paket Laundry")

@section("content")
<div class="row justify-content-center">
    <div class="col-md-6">
        <div class="card">
            <div class="card-header"><i class="bi bi-pencil me-1"></i> Form Edit Paket</div>
            <div class="card-body">
                <form action="{{ route("packages.update", $package) }}" method="POST">
                    @csrf @method("PUT")
                    <div class="mb-3">
                        <label class="form-label">Nama Paket <span class="text-danger">*</span></label>
                        <input type="text" name="nama" class="form-control @error("nama") is-invalid @enderror" value="{{ old("nama", $package->nama) }}" required>
                        @error("nama") <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Deskripsi</label>
                        <textarea name="deskripsi" class="form-control @error("deskripsi") is-invalid @enderror" rows="3">{{ old("deskripsi", $package->deskripsi) }}</textarea>
                        @error("deskripsi") <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Berat (Kg) <span class="text-danger">*</span></label>
                        <input type="number" name="berat_kg" class="form-control @error("berat_kg") is-invalid @enderror" value="{{ old("berat_kg", $package->berat_kg) }}" required min="0.1" step="0.5">
                        @error("berat_kg") <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Harga <span class="text-danger">*</span></label>
                        <div class="input-group">
                            <span class="input-group-text">Rp</span>
                            <input type="number" name="harga" class="form-control @error("harga") is-invalid @enderror" value="{{ old("harga", $package->harga) }}" required min="0">
                            @error("harga") <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                    </div>
                    <div class="mb-3">
                        <div class="form-check form-switch">
                            <input class="form-check-input" type="checkbox" name="aktif" id="aktif" value="1" {{ old("aktif", $package->aktif) ? "checked" : "" }}>
                            <label class="form-check-label" for="aktif">Aktif</label>
                        </div>
                    </div>
                    <div class="d-flex gap-2">
                        <button type="submit" class="btn btn-primary"><i class="bi bi-save"></i> Update</button>
                        <a href="{{ route("packages.index") }}" class="btn btn-outline-secondary">Batal</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
