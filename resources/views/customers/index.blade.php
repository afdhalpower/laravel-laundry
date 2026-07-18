@extends("layouts.admin")
@section("title", "Pelanggan")
@section("page_title", "Data Pelanggan")

@section("content")
<div class="page-title">
    <span>Total: {{ $customers->total() }} pelanggan</span>
    <a href="{{ route("customers.create") }}" class="btn btn-primary">
        <i class="bi bi-plus-lg"></i> Tambah Pelanggan
    </a>
</div>

<div class="card">
    <div class="card-body p-0">
        <div class="p-3 border-bottom">
            <form action="{{ route("customers.index") }}" method="GET" class="row g-2">
                <div class="col-md-4">
                    <div class="input-group">
                        <span class="input-group-text"><i class="bi bi-search"></i></span>
                        <input type="text" name="search" class="form-control" placeholder="Cari nama atau telepon..." value="{{ request("search") }}">
                    </div>
                </div>
                <div class="col-auto">
                    <button class="btn btn-outline-primary" type="submit">Cari</button>
                    <a href="{{ route("customers.index") }}" class="btn btn-outline-secondary">Reset</a>
                </div>
            </form>
        </div>

        <div class="table-responsive">
            <table class="table table-hover mb-0">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Nama</th>
                        <th>No. Telepon</th>
                        <th>Alamat</th>
                        <th>Total Order</th>
                        <th>Bergabung</th>
                        <th class="text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($customers as $customer)
                    <tr>
                        <td>{{ $loop->iteration + ($customers->currentPage() - 1) * $customers->perPage() }}</td>
                        <td class="fw-medium"><a href="{{ route("customers.show", $customer) }}" class="text-decoration-none">{{ $customer->nama }}</a></td>
                        <td>{{ $customer->no_telp }}</td>
                        <td class="text-muted small">{{ Str::limit($customer->alamat, 40) ?? "-" }}</td>
                        <td><span class="badge bg-secondary">{{ $customer->orders_count ?? 0 }}</span></td>
                        <td class="small text-muted">{{ $customer->created_at->format("d/m/Y") }}</td>
                        <td class="text-center">
                            <a href="{{ route("customers.edit", $customer) }}" class="btn btn-sm btn-outline-primary" title="Edit">
                                <i class="bi bi-pencil"></i>
                            </a>
                            <form action="{{ route("customers.destroy", $customer) }}" method="POST" class="d-inline" onsubmit="return confirm("Hapus pelanggan ini?")">
                                @csrf @method("DELETE")
                                <button class="btn btn-sm btn-outline-danger" title="Hapus">
                                    <i class="bi bi-trash"></i>
                                </button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="text-center py-4 text-muted">
                            <i class="bi bi-people fs-1 d-block mb-2"></i>
                            Belum ada pelanggan. <a href="{{ route("customers.create") }}">Tambah sekarang</a>.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

<div class="mt-3">
    {{ $customers->links() }}
</div>
@endsection
