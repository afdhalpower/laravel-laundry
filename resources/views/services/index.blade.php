@extends("layouts.admin")
@section("title", "Layanan")
@section("page_title", "Daftar Layanan")

@section("content")
<div class="page-title">
    <span>{{ $services->total() }} layanan</span>
    <a href="{{ route("services.create") }}" class="btn btn-primary">
        <i class="bi bi-plus-lg"></i> Tambah Layanan
    </a>
</div>

<div class="card">
    <div class="card-body p-0">
        <div class="p-3 border-bottom">
            <form action="{{ route("services.index") }}" method="GET" class="row g-2">
                <div class="col-md-4">
                    <div class="input-group">
                        <span class="input-group-text"><i class="bi bi-search"></i></span>
                        <input type="text" name="search" class="form-control" placeholder="Cari layanan..." value="{{ request("search") }}">
                    </div>
                </div>
                <div class="col-auto">
                    <button class="btn btn-outline-primary" type="submit">Cari</button>
                    <a href="{{ route("services.index") }}" class="btn btn-outline-secondary">Reset</a>
                </div>
            </form>
        </div>

        <div class="table-responsive">
            <table class="table table-hover mb-0">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Nama Layanan</th>
                        <th>Tipe</th>
                        <th>Harga</th>
                        <th>Estimasi</th>
                        <th class="text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($services as $service)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td class="fw-medium">{{ $service->nama }}</td>
                        <td>
                            @if($service->tipe == "kiloan")
                                <span class="badge bg-info"><i class="bi bi-box-seam"></i> Kiloan</span>
                            @else
                                <span class="badge bg-warning text-dark"><i class="bi bi-box"></i> Satuan</span>
                            @endif
                        </td>
                        <td class="fw-semibold">Rp {{ number_format($service->harga, 0, ",", ".") }}</td>
                        <td>{{ $service->estimasi_hari }} hari</td>
                        <td class="text-center">
                            <a href="{{ route("services.edit", $service) }}" class="btn btn-sm btn-outline-primary">
                                <i class="bi bi-pencil"></i>
                            </a>
                            <form action="{{ route("services.destroy", $service) }}" method="POST" class="d-inline" onsubmit="return confirm("Hapus layanan ini?")">
                                @csrf @method("DELETE")
                                <button class="btn btn-sm btn-outline-danger">
                                    <i class="bi bi-trash"></i>
                                </button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="text-center py-4 text-muted">
                            <i class="bi bi-gear fs-1 d-block mb-2"></i>
                            Belum ada layanan. <a href="{{ route("services.create") }}">Tambah sekarang</a>.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

<div class="mt-3">{{ $services->links() }}</div>
@endsection
