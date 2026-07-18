@extends("layouts.admin")
@section("title", "Detail Pelanggan")
@section("page_title", "Detail Pelanggan")

@section("content")
<div class="row">
    <div class="col-md-4">
        {{-- Kartu Info Pelanggan --}}
        <div class="card mb-3">
            <div class="card-header">
                <i class="bi bi-person me-1"></i> Informasi Pelanggan
            </div>
            <div class="card-body">
                <div class="text-center mb-3">
                    <div class="rounded-circle bg-primary text-white d-flex align-items-center justify-content-center mx-auto"
                        style="width: 72px; height: 72px; font-size: 1.75rem; font-weight: 700;">
                        {{ strtoupper(substr($customer->nama, 0, 1)) }}
                    </div>
                    <h5 class="mt-2 mb-0 fw-semibold">{{ $customer->nama }}</h5>
                </div>
                <hr>
                <div class="mb-2">
                    <small class="text-muted d-block"><i class="bi bi-telephone me-1"></i> No. Telepon</small>
                    <span>{{ $customer->no_telp }}</span>
                </div>
                <div class="mb-2">
                    <small class="text-muted d-block"><i class="bi bi-geo-alt me-1"></i> Alamat</small>
                    <span>{{ $customer->alamat ?? "-" }}</span>
                </div>
                <div class="mb-2">
                    <small class="text-muted d-block"><i class="bi bi-receipt me-1"></i> Total Order</small>
                    <span class="badge bg-secondary fs-6">{{ $customer->orders_count ?? 0 }}</span>
                </div>
                <div>
                    <small class="text-muted d-block"><i class="bi bi-calendar me-1"></i> Bergabung Sejak</small>
                    <span>{{ $customer->created_at->format("d/m/Y") }}</span>
                </div>
            </div>
            <div class="card-footer bg-transparent d-flex gap-2">
                <a href="{{ route("customers.edit", $customer) }}" class="btn btn-outline-primary btn-sm flex-fill">
                    <i class="bi bi-pencil"></i> Edit
                </a>
                <a href="{{ route("customers.index") }}" class="btn btn-outline-secondary btn-sm flex-fill">
                    <i class="bi bi-arrow-left"></i> Kembali
                </a>
            </div>
        </div>
    </div>

    <div class="col-md-8">
        {{-- Daftar Order --}}
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <span><i class="bi bi-receipt me-1"></i> Riwayat Transaksi</span>
                <span class="text-muted small">Total: {{ $orders->total() }} transaksi</span>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover mb-0">
                        <thead>
                            <tr>
                                <th>No. Order</th>
                                <th>Tgl Masuk</th>
                                <th>Status</th>
                                <th>Total Harga</th>
                                <th class="text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($orders as $order)
                            <tr>
                                <td class="fw-semibold">{{ $order->no_order }}</td>
                                <td class="small">{{ $order->tgl_masuk->format("d/m/Y") }}</td>
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
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="5" class="text-center py-4 text-muted">
                                    <i class="bi bi-receipt fs-1 d-block mb-2"></i>
                                    Belum ada transaksi untuk pelanggan ini.
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <div class="mt-3">
            {{ $orders->links() }}
        </div>
    </div>
</div>
@endsection
