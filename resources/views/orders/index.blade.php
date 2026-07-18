@extends("layouts.admin")
@section("title", "Transaksi")
@section("page_title", "Data Transaksi Laundry")

@section("content")
<div class="page-title">
    <span>{{ $orders->total() }} transaksi</span>
    <a href="{{ route("orders.create") }}" class="btn btn-primary">
        <i class="bi bi-plus-lg"></i> Transaksi Baru
    </a>
</div>

<div class="card">
    <div class="card-body p-0">
        <div class="p-3 border-bottom">
            <form action="{{ route("orders.index") }}" method="GET" class="row g-2">
                <div class="col-md-3">
                    <div class="input-group">
                        <span class="input-group-text"><i class="bi bi-search"></i></span>
                        <input type="text" name="search" class="form-control" placeholder="No. order atau nama..." value="{{ request("search") }}">
                    </div>
                </div>
                <div class="col-md-2">
                    <select name="status" class="form-select">
                        <option value="">Semua Status</option>
                        <option value="diterima" {{ request("status") == "diterima" ? "selected" : "" }}>Diterima</option>
                        <option value="dicuci" {{ request("status") == "dicuci" ? "selected" : "" }}>Dicuci</option>
                        <option value="dikeringkan" {{ request("status") == "dikeringkan" ? "selected" : "" }}>Dikeringkan</option>
                        <option value="disetrika" {{ request("status") == "disetrika" ? "selected" : "" }}>Disetrika</option>
                        <option value="dilipat" {{ request("status") == "dilipat" ? "selected" : "" }}>Dilipat</option>
                        <option value="siap" {{ request("status") == "siap" ? "selected" : "" }}>Siap</option>
                        <option value="diantar" {{ request("status") == "diantar" ? "selected" : "" }}>Diantar</option>
                        <option value="selesai" {{ request("status") == "selesai" ? "selected" : "" }}>Selesai</option>
                    </select>
                </div>
                <div class="col-auto">
                    <button class="btn btn-outline-primary" type="submit"><i class="bi bi-funnel"></i> Filter</button>
                    <a href="{{ route("orders.index") }}" class="btn btn-outline-secondary">Reset</a>
                </div>
            </form>
        </div>

        <div class="table-responsive">
            <table class="table table-hover mb-0">
                <thead>
                    <tr>
                        <th>No. Order</th>
                        <th>Pelanggan</th>
                        <th>Tgl Masuk</th>
                        <th>Tgl Selesai</th>
                        <th>Status</th>
                        <th>Total</th>
                        <th class="text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($orders as $order)
                    <tr>
                        <td class="fw-semibold">{{ $order->no_order }}</td>
                        <td>{{ $order->customer->nama }}</td>
                        <td class="small">{{ $order->tgl_masuk->format("d/m/Y") }}</td>
                        <td class="small">{{ $order->tgl_selesai?->format("d/m/Y") ?? "-" }}</td>
                        <td>
                            <span class="badge bg-{{ $order->status_color }} badge-status">
                                <i class="bi bi-{{ $order->status == "selesai" ? "check-circle" : "hourglass-split" }}"></i>
                                {{ $order->status_label }}
                            </span>
                        </td>
                        <td class="fw-semibold">Rp {{ number_format($order->total_harga, 0, ",", ".") }}</td>
                        <td class="text-center">
                            <a href="{{ route("orders.show", $order) }}" class="btn btn-sm btn-outline-info" title="Detail">
                                <i class="bi bi-eye"></i>
                            </a>
                            <a href="{{ route("orders.edit", $order) }}" class="btn btn-sm btn-outline-primary" title="Edit">
                                <i class="bi bi-pencil"></i>
                            </a>
                            <a href="{{ route("orders.payment", $order) }}" class="btn btn-sm btn-outline-success" title="Pembayaran">
                                <i class="bi bi-cash"></i>
                            </a>
                            <a href="{{ route("orders.invoice", $order) }}" class="btn btn-sm btn-outline-secondary" title="Invoice" target="_blank">
                                <i class="bi bi-printer"></i>
                            </a>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="text-center py-4 text-muted">
                            <i class="bi bi-receipt fs-1 d-block mb-2"></i>
                            Belum ada transaksi. <a href="{{ route("orders.create") }}">Buat transaksi baru</a>.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
<div class="mt-3">{{ $orders->links() }}</div>
@endsection
