@extends("layouts.admin")
@section("title", "Trash Order")
@section("page_title", "Order Terhapus")

@section("content")
<div class="page-title">
    <span>Total: {{ $orders->total() }} order dihapus</span>
    <div>
        <a href="{{ route("orders.index") }}" class="btn btn-outline-secondary">
            <i class="bi bi-arrow-left"></i> Kembali
        </a>
    </div>
</div>

<div class="card">
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover mb-0">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>No. Order</th>
                        <th>Pelanggan</th>
                        <th>Status</th>
                        <th>Total</th>
                        <th>Dihapus</th>
                        <th class="text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($orders as $order)
                    <tr>
                        <td>{{ $loop->iteration + ($orders->currentPage() - 1) * $orders->perPage() }}</td>
                        <td class="fw-medium">{{ $order->no_order }}</td>
                        <td>{{ $order->customer->nama ?? "-" }}</td>
                        <td><span class="badge bg-secondary">{{ ucfirst($order->status) }}</span></td>
                        <td>Rp {{ number_format($order->total_harga, 0, ",", ".") }}</td>
                        <td class="small text-muted">{{ $order->deleted_at->format("d/m/Y H:i") }}</td>
                        <td class="text-center">
                            <form action="{{ route("orders.restore", $order->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Kembalikan order ini?')">
                                @csrf @method("PATCH")
                                <button class="btn btn-sm btn-success" title="Restore"><i class="bi bi-arrow-counterclockwise"></i> Restore</button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="text-center py-4 text-muted">
                            <i class="bi bi-trash fs-1 d-block mb-2"></i>
                            Tidak ada order yang dihapus.
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
@endsection