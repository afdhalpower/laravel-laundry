@extends("layouts.admin")
@section("title", "Tambah Pengeluaran")
@section("page_title", "Tambah Pengeluaran")

@section("content")
<div class="row justify-content-center">
    <div class="col-md-6">
        <div class="card">
            <div class="card-header"><i class="bi bi-plus-circle me-1"></i> Form Pengeluaran Baru</div>
            <div class="card-body">
                <form action="{{ route("expenses.store") }}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label class="form-label">Judul <span class="text-danger">*</span></label>
                        <input type="text" name="judul" class="form-control @error("judul") is-invalid @enderror" value="{{ old("judul") }}" required maxlength="200">
                        @error("judul") <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Kategori <span class="text-danger">*</span></label>
                        <select name="kategori" class="form-select @error("kategori") is-invalid @enderror" required>
                            <option value="">-- Pilih Kategori --</option>
                            <option value="deterjen" {{ old("kategori") == "deterjen" ? "selected" : "" }}>Deterjen</option>
                            <option value="listrik" {{ old("kategori") == "listrik" ? "selected" : "" }}>Listrik</option>
                            <option value="air" {{ old("kategori") == "air" ? "selected" : "" }}>Air</option>
                            <option value="gaji" {{ old("kategori") == "gaji" ? "selected" : "" }}>Gaji</option>
                            <option value="lainnya" {{ old("kategori") == "lainnya" ? "selected" : "" }}>Lainnya</option>
                        </select>
                        @error("kategori") <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Jumlah <span class="text-danger">*</span></label>
                        <div class="input-group">
                            <span class="input-group-text">Rp</span>
                            <input type="number" name="jumlah" class="form-control @error("jumlah") is-invalid @enderror" value="{{ old("jumlah") }}" required min="0">
                            @error("jumlah") <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Tanggal Pengeluaran <span class="text-danger">*</span></label>
                        <input type="date" name="tgl_pengeluaran" class="form-control @error("tgl_pengeluaran") is-invalid @enderror" value="{{ old("tgl_pengeluaran", date("Y-m-d")) }}" required>
                        @error("tgl_pengeluaran") <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Deskripsi</label>
                        <textarea name="deskripsi" class="form-control @error("deskripsi") is-invalid @enderror" rows="3">{{ old("deskripsi") }}</textarea>
                        @error("deskripsi") <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                    <div class="d-flex gap-2">
                        <button type="submit" class="btn btn-primary"><i class="bi bi-save"></i> Simpan</button>
                        <a href="{{ route("expenses.index") }}" class="btn btn-outline-secondary">Batal</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
