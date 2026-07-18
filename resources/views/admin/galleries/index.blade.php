@extends("layouts.admin")
@section("title", "Galeri")
@section("page_title", "Galeri Foto")
@section("page_subtitle", "Kelola foto untuk landing page")

@section("content")
@if(session("success"))
    <div class="alert alert-success alert-dismissible py-2 small">{{ session("success") }}<button type="button" class="btn-close py-2" data-bs-dismiss="alert"></button></div>
@endif

<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <span><i class="bi bi-images me-1"></i> Foto</span>
        <a href="{{ route("admin.galleries.create") }}" class="btn btn-primary btn-sm">
            <i class="bi bi-plus-lg"></i> Upload
        </a>
    </div>
    <div class="card-body">
        <div class="row g-3">
            @forelse($galleries as $g)
                <div class="col-6 col-md-4 col-lg-3">
                    <div class="card h-100">
                        <img src="{{ Storage::url($g->photo) }}" class="card-img-top" style="height:160px;object-fit:cover">
                        <div class="card-body p-2">
                            <p class="small mb-1 text-truncate">{{ $g->caption ?? "—" }}</p>
                            <div class="d-flex justify-content-between align-items-center">
                                <span class="badge bg-{{ $g->is_active ? "success" : "secondary" }} small">
                                    {{ $g->is_active ? "Aktif" : "Nonaktif" }}
                                </span>
                                <div>
                                    <a href="{{ route("admin.galleries.edit", $g) }}" class="btn btn-sm btn-outline-primary">
                                        <i class="bi bi-pencil"></i>
                                    </a>
                                    <form action="{{ route("admin.galleries.destroy", $g) }}" method="POST" class="d-inline"
                                        onsubmit="return confirm("Hapus foto ini?")">
                                        @csrf @method("DELETE")
                                        <button class="btn btn-sm btn-outline-danger"><i class="bi bi-trash"></i></button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-12 text-center text-muted py-4">Belum ada foto</div>
            @endforelse
        </div>
    </div>
    @if($galleries->hasPages())
        <div class="card-footer">{{ $galleries->links() }}</div>
    @endif
</div>
@endsection
