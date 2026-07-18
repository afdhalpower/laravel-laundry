@extends("layouts.admin")
@section("title", "Pembayaran")
@section("page_title", "Pembayaran #" . $order->no_order)

@section("content")
<div class="row justify-content-center">
    <div class="col-md-6">
        <div class="card mb-3">
            <div class="card-header"><i class="bi bi-receipt me-1"></i> Info Order</div>
            <div class="card-body">
                <div class="d-flex justify-content-between mb-2">
                    <span>Pelanggan:</span>
                    <span class="fw-semibold">{{ $order->customer->nama }}</span>
                </div>
                <div class="d-flex justify-content-between mb-2">
                    <span>Total:</span>
                    <span class="fw-bold fs-5">Rp {{ number_format($order->total_harga, 0, ",", ".") }}</span>
                </div>
                @php $dibayar = $order->payments->sum("jumlah"); $sisa = $order->total_harga - $dibayar; @endphp
                <div class="d-flex justify-content-between mb-2">
                    <span>Sudah Dibayar:</span>
                    <span class="text-success">Rp {{ number_format($dibayar, 0, ",", ".") }}</span>
                </div>
                <div class="d-flex justify-content-between">
                    <span>Sisa:</span>
                    <span class="text-{{ $sisa > 0 ? "danger" : "success" }} fw-bold">Rp {{ number_format($sisa, 0, ",", ".") }}</span>
                </div>
            </div>
        </div>

        <div class="card">
            <div class="card-header"><i class="bi bi-cash me-1"></i> Form Pembayaran</div>
            <div class="card-body">
                <form action="{{ route("payments.store") }}" method="POST">
                    @csrf
                    <input type="hidden" name="order_id" value="{{ $order->id }}">
                    <div class="mb-3">
                        <label class="form-label">Tanggal Bayar <span class="text-danger">*</span></label>
                        <input type="date" name="tgl_bayar" class="form-control" value="{{ old("tgl_bayar", date("Y-m-d")) }}" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Jumlah Pembayaran <span class="text-danger">*</span></label>
                        <div class="input-group">
                            <span class="input-group-text">Rp</span>
                            <input type="number" name="jumlah" class="form-control @error("jumlah") is-invalid @enderror" value="{{ old("jumlah", $sisa > 0 ? $sisa : 0) }}" required min="1">
                        </div>
                        @error("jumlah") <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Metode Pembayaran <span class="text-danger">*</span></label>
                        <select name="metode" class="form-select" required>
                            <option value="tunai" {{ old("metode") == "tunai" ? "selected" : "" }}>Tunai</option>
                            <option value="transfer" {{ old("metode") == "transfer" ? "selected" : "" }}>Transfer</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Keterangan</label>
                        <input type="text" name="keterangan" class="form-control" value="{{ old("keterangan") }}">
                    </div>
                    <button type="submit" class="btn btn-success w-100">
                        <i class="bi bi-check-lg"></i> Konfirmasi Pembayaran
                    </button>
                </form>
            </div>
        </div>

        @if($order->payments->count() > 0)
        <div class="card mt-3">
            <div class="card-header"><i class="bi bi-clock-history me-1"></i> Riwayat Pembayaran</div>
            <div class="card-body p-0">
                <table class="table mb-0">
                    <thead>
                        <tr>
                            <th>Tanggal</th>
                            <th>Metode</th>
                            <th>Jumlah</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($order->payments as $pm)
                        <tr>
                            <td>{{ $pm->tgl_bayar->format("d/m/Y") }}</td>
                            <td><span class="badge bg-light text-dark">{{ ucfirst($pm->metode) }}</span></td>
                            <td class="fw-semibold">Rp {{ number_format($pm->jumlah, 0, ",", ".") }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        @endif
    </div>
</div>
@endsection
