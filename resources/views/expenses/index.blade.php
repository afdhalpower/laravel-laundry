@extends("layouts.admin")
@section("title", "Pengeluaran")
@section("page_title", "Daftar Pengeluaran")

@section("content")
<div class="page-title">
    <span>{{ $expenses->total() }} pengeluaran</span>
    <a href="{{ route("expenses.create") }}" class="btn btn-primary">
        <i class="bi bi-plus-lg"></i> Tambah Pengeluaran
    </a>
</div>

<div class="card">
    <div class="card-body p-0">
        <div class="p-3 border-bottom">
            <form action="{{ route("expenses.index") }}" method="GET" class="row g-2">
                <div class="col-md-4">
                    <div class="input-group">
                        <span class="input-group-text"><i class="bi bi-search"></i></span>
                        <input type="text" name="search" class="form-control" placeholder="Cari pengeluaran..." value="{{ request("search") }}">
                    </div>
                </div>
                <div class="col-md-3">
                    <select name="kategori" class="form-select">
                        <option value="">Semua Kategori</option>
                        <option value="deterjen" {{ request("kategori") == "deterjen" ? "selected" : "" }}>Deterjen</option>
                        <option value="listrik" {{ request("kategori") == "listrik" ? "selected" : "" }}>Listrik</option>
                        <option value="air" {{ request("kategori") == "air" ? "selected" : "" }}>Air</option>
                        <option value="gaji" {{ request("kategori") == "gaji" ? "selected" : "" }}>Gaji</option>
                        <option value="lainnya" {{ request("kategori") == "lainnya" ? "selected" : "" }}>Lainnya</option>
                    </select>
                </div>
                <div class="col-auto">
                    <button class="btn btn-outline-primary" type="submit">Cari</button>
                    <a href="{{ route("expenses.index") }}" class="btn btn-outline-secondary">Reset</a>
                </div>
            </form>
        </div>

        <div class="table-responsive">
            <table class="table table-hover mb-0">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Judul</th>
                        <th>Kategori</th>
                        <th>Jumlah</th>
                        <th>Tanggal</th>
                        <th>Dicatat Oleh</th>
                        <th class="text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($expenses as $expense)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td class="fw-medium">{{ $expense->judul }}
                            @if($expense->deskripsi)
                                <br><small class="text-muted">{{ Str::limit($expense->deskripsi, 60) }}</small>
                            @endif
                        </td>
                        <td>
                            @php
                                $catColors = ["deterjen" => "info", "listrik" => "warning", "air" => "primary", "gaji" => "success", "lainnya" => "secondary"];
                            @endphp
                            <span class="badge bg-{{ $catColors[$expense->kategori] ?? "secondary" }}">
                                {{ ucfirst($expense->kategori) }}
                            </span>
                        </td>
                        <td class="fw-semibold">Rp {{ number_format($expense->jumlah, 0, ",", ".") }}</td>
                        <td class="small">{{ $expense->tgl_pengeluaran->format("d/m/Y") }}</td>
                        <td class="small">{{ $expense->user?->name ?? "-" }}</td>
                        <td class="text-center">
                            <a href="{{ route("expenses.edit", $expense) }}" class="btn btn-sm btn-outline-primary">
                                <i class="bi bi-pencil"></i>
                            </a>
                            <form action="{{ route("expenses.destroy", $expense) }}" method="POST" class="d-inline" onsubmit="return confirm('Hapus pengeluaran ini?')">
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
                            <i class="bi bi-wallet2 fs-1 d-block mb-2"></i>
                            Belum ada pengeluaran. <a href="{{ route("expenses.create") }}">Catat sekarang</a>.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

<div class="mt-3">{{ $expenses->links() }}</div>
@endsection
