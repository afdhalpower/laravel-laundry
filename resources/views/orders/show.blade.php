@extends("layouts.admin")
@section("title", "Detail Order")
@section("page_title", "Detail Order #" . $order->no_order)

@section("content")
<div class="row">
    <div class="col-md-8">
        {{-- Informasi Order --}}
        <div class="card mb-3">
            <div class="card-header d-flex justify-content-between align-items-center">
                <span><i class="bi bi-info-circle me-1"></i> Informasi Order</span>
                <span class="badge bg-{{ $order->status_color }} fs-6">{{ $order->status_label }}</span>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-4 mb-2">
                        <small class="text-muted d-block">No. Order</small>
                        <span class="fw-semibold">{{ $order->no_order }}</span>
                    </div>
                    <div class="col-md-4 mb-2">
                        <small class="text-muted d-block">Pelanggan</small>
                        <span class="fw-semibold">{{ $order->customer->nama }}</span>
                    </div>
                    <div class="col-md-4 mb-2">
                        <small class="text-muted d-block">Telepon</small>
                        <span>{{ $order->customer->no_telp }}</span>
                    </div>
                    <div class="col-md-4 mb-2">
                        <small class="text-muted d-block">Tanggal Masuk</small>
                        <span>{{ $order->tgl_masuk->format("d/m/Y") }}</span>
                    </div>
                    <div class="col-md-4 mb-2">
                        <small class="text-muted d-block">Tanggal Selesai</small>
                        <span>{{ $order->tgl_selesai?->format("d/m/Y") ?? "-" }}</span>
                    </div>
                    <div class="col-md-4 mb-2">
                        <small class="text-muted d-block">Total Harga</small>
                        <span class="fw-bold fs-5 text-primary">Rp {{ number_format($order->total_harga, 0, ",", ".") }}</span>
                    </div>
                </div>
                @if($order->catatan)
                    <div class="mt-2 p-3 bg-light rounded">
                        <small class="text-muted d-block">Catatan:</small>
                        {{ $order->catatan }}
                    </div>
                @endif
            </div>
        </div>

        {{-- Item Layanan --}}
        <div class="card mb-3">
            <div class="card-header"><i class="bi bi-box-seam me-1"></i> Item Layanan</div>
            <div class="card-body p-0">
                <table class="table mb-0">
                    <thead>
                        <tr>
                            <th>Layanan</th>
                            <th>Tipe</th>
                            <th>Berat/Jumlah</th>
                            <th>Harga Satuan</th>
                            <th>Subtotal</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($order->items as $item)
                        <tr>
                            <td>{{ $item->service->nama }}</td>
                            <td><span class="badge bg-{{ $item->jenis == "kiloan" ? "info" : "warning" }}">{{ ucfirst($item->jenis) }}</span></td>
                            <td>
                                @if($item->jenis == "kiloan")
                                    {{ $item->berat }} kg
                                @else
                                    {{ $item->jumlah }} item
                                @endif
                            </td>
                            <td>Rp {{ number_format($item->harga_satuan, 0, ",", ".") }}</td>
                            <td>Rp {{ number_format($item->subtotal, 0, ",", ".") }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                    <tfoot>
                        <tr class="table-active">
                            <th colspan="4" class="text-end">Total:</th>
                            <th class="fw-bold">Rp {{ number_format($order->total_harga, 0, ",", ".") }}</th>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    </div>

    <div class="col-md-4">
        {{-- Status Update --}}
        <div class="card mb-3">
            <div class="card-header"><i class="bi bi-arrow-repeat me-1"></i> Update Status</div>
            <div class="card-body">
                <form action="{{ route("orders.update", $order) }}" method="POST">
                    @csrf @method("PUT")
                    <input type="hidden" name="customer_id" value="{{ $order->customer_id }}">
                    <input type="hidden" name="tgl_masuk" value="{{ $order->tgl_masuk->format("Y-m-d") }}">
                    <div class="mb-3">
                        <label class="form-label">Status</label>
                        <select name="status" class="form-select">
                            @foreach(["diterima","dicuci","dikeringkan","disetrika","dilipat","siap","diantar","selesai"] as $st)
                                <option value="{{ $st }}" {{ $order->status == $st ? "selected" : "" }}>
                                    {{ ucfirst($st) }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Tanggal Selesai</label>
                        <input type="date" name="tgl_selesai" class="form-control" value="{{ $order->tgl_selesai?->format("Y-m-d") ?? "" }}">
                    </div>
                    <button type="submit" class="btn btn-primary w-100">
                        <i class="bi bi-check-lg"></i> Update Status
                    </button>
                </form>
            </div>
        </div>

        {{-- Pembayaran --}}
        <div class="card">
            <div class="card-header d-flex justify-content-between">
                <span><i class="bi bi-wallet me-1"></i> Pembayaran</span>
                <a href="{{ route("orders.payment", $order) }}" class="btn btn-sm btn-success">
                    <i class="bi bi-plus"></i> Bayar
                </a>
            </div>
            <div class="card-body">
                @php
                    $totalBayar = $order->payments->sum("jumlah");
                    $sisa = $order->total_harga - $totalBayar;
                @endphp
                <div class="d-flex justify-content-between mb-2">
                    <span>Total:</span>
                    <span class="fw-bold">Rp {{ number_format($order->total_harga, 0, ",", ".") }}</span>
                </div>
                <div class="d-flex justify-content-between mb-2">
                    <span>Dibayar:</span>
                    <span class="text-success fw-bold">Rp {{ number_format($totalBayar, 0, ",", ".") }}</span>
                </div>
                @if($sisa > 0)
                <div class="d-flex justify-content-between">
                    <span>Sisa:</span>
                    <span class="text-danger fw-bold">Rp {{ number_format($sisa, 0, ",", ".") }}</span>
                </div>
                @else
                <div class="d-flex justify-content-between">
                    <span class="text-success"><i class="bi bi-check-circle"></i> Lunas</span>
                </div>
                @endif

                @if($order->payments->count() > 0)
                    <hr>
                    <h6>Riwayat Pembayaran</h6>
                    @foreach($order->payments as $pm)
                        <div class="d-flex justify-content-between small mb-1">
                            <span>{{ $pm->tgl_bayar->format("d/m/Y") }} <span class="badge bg-light text-dark">{{ ucfirst($pm->metode) }}</span></span>
                            <span class="fw-semibold">Rp {{ number_format($pm->jumlah, 0, ",", ".") }}</span>
                        </div>
                    @endforeach
                @endif
            </div>
        </div>
    </div>
</div>

<div class="mt-3">
    <a href="{{ route("orders.index") }}" class="btn btn-outline-secondary"><i class="bi bi-arrow-left"></i> Kembali</a>
    <a href="{{ route("orders.invoice", $order) }}" class="btn btn-outline-primary" target="_blank"><i class="bi bi-printer"></i> Cetak Invoice</a>
</div>
@endsection
