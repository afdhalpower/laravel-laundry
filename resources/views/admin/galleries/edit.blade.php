@extends("layouts.admin")
@section("title", "Edit Foto")
@section("page_title", "Edit Foto")

@section("content")
<div class="row justify-content-center">
    <div class="col-lg-6">
        <div class="card">
            <div class="card-body">
                <form method="POST" enctype="multipart/form-data">
                    @csrf @method("PUT")
                    <div class="mb-3 text-center">
                        <img src="{{ Storage::url($gallery->photo) }}" class="rounded" style="max-height:200px">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Ganti Foto (biarkan kosong jika tidak diganti)</label>
                        <input type="file" name="photo" class="form-control @error("photo") is-invalid @enderror"
                            accept="image/jpeg,image/png,image/webp">
                        @error("photo") <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Caption</label>
                        <input type="text" name="caption" class="form-control" value="{{ old("caption", $gallery->caption) }}">
                    </div>
                    <div class="row g-3 mb-4">
                        <div class="col-md-6">
                            <label class="form-label">Urutan</label>
                            <input type="number" name="sort_order" class="form-control" value="{{ old("sort_order", $gallery->sort_order) }}" min="0">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Aktif</label>
                            <div class="form-check mt-2">
                                <input type="checkbox" name="is_active" class="form-check-input" value="1"
                                    {{ $gallery->is_active ? "checked" : "" }} id="active">
                                <label class="form-check-label" for="active">Tampilkan</label>
                            </div>
                        </div>
                    </div>
                    <div class="d-flex gap-2">
                        <button type="submit" class="btn btn-primary"><i class="bi bi-save me-1"></i> Simpan</button>
                        <a href="{{ route("admin.galleries.index") }}" class="btn btn-outline-secondary">Batal</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
