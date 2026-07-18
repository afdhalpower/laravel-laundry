@extends("layouts.admin")
@section("title", "Edit Testimoni")
@section("page_title", "Edit Testimoni")

@section("content")
<div class="row justify-content-center">
    <div class="col-lg-8">
        <div class="card">
            <div class="card-body">
                <form method="POST" enctype="multipart/form-data">
                    @csrf @method("PUT")
                    <div class="mb-3">
                        <label class="form-label">Nama Pelanggan</label>
                        <input type="text" name="customer_name" class="form-control @error("customer_name") is-invalid @enderror"
                            value="{{ old("customer_name", $testimonial->customer_name) }}" required>
                        @error("customer_name") <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Testimoni</label>
                        <textarea name="content" class="form-control @error("content") is-invalid @enderror" rows="4" required>{{ old("content", $testimonial->content) }}</textarea>
                        @error("content") <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                    <div class="row g-3 mb-3">
                        <div class="col-md-4">
                            <label class="form-label">Rating</label>
                            <select name="rating" class="form-select">
                                @for($i=5;$i>=1;$i--)
                                    <option value="{{ $i }}" {{ old("rating",$testimonial->rating)==$i?"selected":"" }}>{{ $i }} ★</option>
                                @endfor
                            </select>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Urutan</label>
                            <input type="number" name="sort_order" class="form-control" value="{{ old("sort_order",$testimonial->sort_order) }}" min="0">
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Aktif</label>
                            <div class="form-check mt-2">
                                <input type="checkbox" name="is_active" class="form-check-input" value="1"
                                    {{ $testimonial->is_active ? "checked" : "" }} id="active">
                                <label class="form-check-label" for="active">Tampilkan</label>
                            </div>
                        </div>
                    </div>
                    <div class="mb-4">
                        <label class="form-label">Foto</label>
                        @if($testimonial->photo)
                            <div class="mb-2">
                                <img src="{{ Storage::url($testimonial->photo) }}" class="rounded" style="max-height:80px">
                            </div>
                        @endif
                        <input type="file" name="photo" class="form-control @error("photo") is-invalid @enderror"
                            accept="image/jpeg,image/png,image/webp">
                        @error("photo") <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                    <div class="d-flex gap-2">
                        <button type="submit" class="btn btn-primary"><i class="bi bi-save me-1"></i> Simpan</button>
                        <a href="{{ route("admin.testimonials.index") }}" class="btn btn-outline-secondary">Batal</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
