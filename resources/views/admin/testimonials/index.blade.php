@extends("layouts.admin")
@section("title", "Testimoni")
@section("page_title", "Testimoni")
@section("page_subtitle", "Kelola testimoni pelanggan")

@section("content")
@if(session("success"))
    <div class="alert alert-success alert-dismissible py-2 small">{{ session("success") }}<button type="button" class="btn-close py-2" data-bs-dismiss="alert"></button></div>
@endif

<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <span><i class="bi bi-star me-1"></i> Daftar Testimoni</span>
        <a href="{{ route("admin.testimonials.create") }}" class="btn btn-primary btn-sm">
            <i class="bi bi-plus-lg"></i> Tambah
        </a>
    </div>
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover mb-0">
                <thead class="table-light">
                    <tr>
                        <th>#</th>
                        <th>Pelanggan</th>
                        <th>Isi</th>
                        <th>Rating</th>
                        <th>Aktif</th>
                        <th>Urutan</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($testimonials as $t)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td class="fw-medium">{{ $t->customer_name }}</td>
                            <td class="small text-muted" style="max-width:300px">
                                {{ Str::limit($t->content, 80) }}
                            </td>
                            <td>
                                @for($i=1;$i<=5;$i++)
                                    <i class="bi bi-star{{ $i<=$t->rating ? "-fill text-warning" : "" }}"></i>
                                @endfor
                            </td>
                            <td>
                                @if($t->is_active)
                                    <span class="badge bg-success">Aktif</span>
                                @else
                                    <span class="badge bg-secondary">Tidak</span>
                                @endif
                            </td>
                            <td>{{ $t->sort_order }}</td>
                            <td class="text-end">
                                <a href="{{ route("admin.testimonials.edit", $t) }}" class="btn btn-sm btn-outline-primary">
                                    <i class="bi bi-pencil"></i>
                                </a>
                                <form action="{{ route("admin.testimonials.destroy", $t) }}" method="POST" class="d-inline"
                                    onsubmit="return confirm("Hapus testimoni ini?")">
                                    @csrf @method("DELETE")
                                    <button class="btn btn-sm btn-outline-danger"><i class="bi bi-trash"></i></button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="7" class="text-center text-muted py-4">Belum ada testimoni</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
    @if($testimonials->hasPages())
        <div class="card-footer">{{ $testimonials->links() }}</div>
    @endif
</div>
@endsection
