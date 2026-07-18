@extends("layouts.admin")
@section("title", "Paket Laundry")
@section("page_title", "Daftar Paket Laundry")

@section("content")
<div class="page-title">
    <span>{{ $packages->total() }} paket</span>
    <a href="{{ route("packages.create") }}" class="btn btn-primary">
        <i class="bi bi-plus-lg"></i> Tambah Paket
    </a>
</div>

<div class="card">
    <div class="card-body p-0">
        <div class="p-3 border-bottom">
            <form action="{{ route("packages.index") }}" method="GET" class="row g-2">
                <div class="col-md-4">
                    <div class="input-group">
                        <span class="input-group-text"><i class="bi bi-search"></i></span>
                        <input type="text" name="search" class="form-control" placeholder="Cari paket..." value="{{ request("search") }}">
                    </div>
                </div>
                <div class="col-auto">
                    <button class="btn btn-outline-primary" type="submit">Cari</button>
                    <a href="{{ route("packages.index") }}" class="btn btn-outline-secondary">Reset</a>
                </div>
            </form>
        </div>

        <div class="table-responsive">
            <table class="table table-hover mb-0">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Nama Paket</th>
                        <th>Deskripsi</th>
                        <th>Berat (Kg)</th>
                        <th>Harga</th>
                        <th class="text-center">Status</th>
                        <th class="text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($packages as $package)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td class="fw-medium">{{ $package->nama }}</td>
                        <td><small class="text-muted">{{ $package->deskripsi ? Str::limit($package->deskripsi, 50) : "-" }}</small></td>
                        <td>{{ number_format($package->berat_kg, 2, ",", ".") }} kg</td>
                        <td class="fw-semibold">Rp {{ number_format($package->harga, 0, ",", ".") }}</td>
                        <td class="text-center">
                            @if($package->aktif)
                                <span class="badge bg-success"><i class="bi bi-check-circle"></i> Aktif</span>
                            @else
                                <span class="badge bg-secondary"><i class="bi bi-x-circle"></i> Nonaktif</span>
                            @endif
                        </td>
                        <td class="text-center">
                            <a href="{{ route("packages.edit", $package) }}" class="btn btn-sm btn-outline-primary">
                                <i class="bi bi-pencil"></i>
                            </a>
                            <form action="{{ route("packages.destroy", $package) }}" method="POST" class="d-inline" onsubmit="return confirm('Hapus paket ini?')">
                                @csrf @method("DELETE")
                                <button class="btn btn-sm btn-outline-danger">
                                    <i class="bi bi-trash"></i>
                                </button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="text-center py-4 text-muted">
                            <i class="bi bi-box fs-1 d-block mb-2"></i>
                            Belum ada paket. <a href="{{ route("packages.create") }}">Tambah sekarang</a>.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

<div class="mt-3">{{ $packages->links() }}</div>
@endsection
