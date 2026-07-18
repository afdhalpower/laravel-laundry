@extends("layouts.admin")
@section("title", "Pengaturan Landing Page")
@section("page_title", "Pengaturan Landing Page")
@section("page_subtitle", "Atur konten halaman depan website")

@section("content")
@if(session("success"))
    <div class="alert alert-success alert-dismissible py-2 small">{{ session("success") }}<button type="button" class="btn-close py-2" data-bs-dismiss="alert"></button></div>
@endif

<form method="POST">
    @csrf

    <div class="row">
        {{-- Hero Section --}}
        <div class="col-lg-8">
            <div class="card mb-4">
                <div class="card-header"><i class="bi bi-house me-1"></i> Hero Section</div>
                <div class="card-body">
                    <div class="mb-3">
                        <label class="form-label">Judul Hero</label>
                        <input type="text" name="hero_title" class="form-control"
                            value="{{ $settings["hero_title"] ?? "Laundry Terpercaya di Kota Anda" }}">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Subjudul</label>
                        <textarea name="hero_subtitle" class="form-control" rows="2">{{ $settings["hero_subtitle"] ?? "Kami siap membantu pakaian Anda bersih, wangi, dan rapi." }}</textarea>
                    </div>
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label">Teks Tombol CTA</label>
                            <input type="text" name="hero_cta_text" class="form-control"
                                value="{{ $settings["hero_cta_text"] ?? "Pesan Sekarang" }}">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">URL Tombol CTA</label>
                            <input type="text" name="hero_cta_url" class="form-control"
                                value="{{ $settings["hero_cta_url"] ?? "https://wa.me/62" }}">
                        </div>
                    </div>
                </div>
            </div>

            {{-- About Section --}}
            <div class="card mb-4">
                <div class="card-header"><i class="bi bi-info-circle me-1"></i> Tentang</div>
                <div class="card-body">
                    <div class="mb-3">
                        <label class="form-label">Judul</label>
                        <input type="text" name="about_title" class="form-control"
                            value="{{ $settings["about_title"] ?? "Tentang LaundryKu" }}">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Konten</label>
                        <textarea name="about_content" class="form-control" rows="4">{{ $settings["about_content"] ?? "LaundryKu adalah jasa laundry profesional yang melayani cuci kering, setrika, dan cuci express. Kami berkomitmen memberikan hasil terbaik untuk pakaian kesayangan Anda." }}</textarea>
                    </div>
                </div>
            </div>

            {{-- Kontak --}}
            <div class="card mb-4">
                <div class="card-header"><i class="bi bi-telephone me-1"></i> Kontak</div>
                <div class="card-body">
                    <div class="mb-3">
                        <label class="form-label">Nomor WhatsApp</label>
                        <input type="text" name="whatsapp_number" class="form-control"
                            value="{{ $settings["whatsapp_number"] ?? "6281234567890" }}"
                            placeholder="628xxx tanpa +">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Alamat</label>
                        <textarea name="address" class="form-control" rows="2">{{ $settings["address"] ?? "" }}</textarea>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Google Maps Embed URL</label>
                        <input type="text" name="map_embed_url" class="form-control"
                            value="{{ $settings["map_embed_url"] ?? "" }}"
                            placeholder="https://www.google.com/maps/embed?pb=...">
                    </div>
                </div>
            </div>
        </div>

        {{-- Samping --}}
        <div class="col-lg-4">
            <div class="card mb-4">
                <div class="card-header"><i class="bi bi-link-45deg me-1"></i> Media Sosial</div>
                <div class="card-body">
                    <div class="mb-3">
                        <label class="form-label">Facebook URL</label>
                        <input type="text" name="facebook_url" class="form-control"
                            value="{{ $settings["facebook_url"] ?? "" }}">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Instagram URL</label>
                        <input type="text" name="instagram_url" class="form-control"
                            value="{{ $settings["instagram_url"] ?? "" }}">
                    </div>
                </div>
            </div>

            <div class="card mb-4">
                <div class="card-header"><i class="bi bi-brush me-1"></i> Footer</div>
                <div class="card-body">
                    <div class="mb-3">
                        <label class="form-label">Teks Footer</label>
                        <input type="text" name="footer_text" class="form-control"
                            value="{{ $settings["footer_text"] ?? "© " . date("Y") . " LaundryKu. All rights reserved." }}">
                    </div>
                </div>
            </div>

            <button type="submit" class="btn btn-primary w-100 mb-3">
                <i class="bi bi-save me-1"></i> Simpan Semua
            </button>
            <a href="{{ url("/") }}" class="btn btn-outline-secondary w-100" target="_blank">
                <i class="bi bi-eye me-1"></i> Lihat Halaman
            </a>
        </div>
    </div>
</form>
@endsection
