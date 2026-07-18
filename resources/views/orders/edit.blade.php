@extends("layouts.admin")
@section("title", "Edit Order")
@section("page_title", "Edit Order #{{ $order->no_order }}")

@section("content")
<form action="{{ route("orders.update", $order) }}" method="POST">
    @csrf @method("PUT")
    <div class="row">
        <div class="col-md-6">
            <div class="card mb-3">
                <div class="card-header"><i class="bi bi-person me-1"></i> Data Order</div>
                <div class="card-body">
                    <div class="mb-3">
                        <label class="form-label">Pelanggan</label>
                        <select name="customer_id" class="form-select @error("customer_id") is-invalid @enderror" required>
                            @foreach($customers as $c)
                                <option value="{{ $c->id }}" {{ old("customer_id", $order->customer_id) == $c->id ? "selected" : "" }}>{{ $c->nama }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Status</label>
                        <select name="status" class="form-select">
                            @foreach(["diterima","dicuci","dikeringkan","disetrika","dilipat","siap","diantar","selesai"] as $st)
                                <option value="{{ $st }}" {{ old("status", $order->status) == $st ? "selected" : "" }}>{{ ucfirst($st) }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Tanggal Masuk</label>
                        <input type="date" name="tgl_masuk" class="form-control" value="{{ old("tgl_masuk", $order->tgl_masuk->format("Y-m-d")) }}" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Tanggal Selesai</label>
                        <input type="date" name="tgl_selesai" class="form-control" value="{{ old("tgl_selesai", $order->tgl_selesai?->format("Y-m-d") ?? "") }}">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Catatan</label>
                        <textarea name="catatan" class="form-control" rows="2">{{ old("catatan", $order->catatan) }}</textarea>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card mb-3">
                <div class="card-header"><i class="bi bi-cart me-1"></i> Item Layanan</div>
                <div class="card-body">
                    @foreach($services as $svc)
                    <div class="mb-2">
                        <label class="d-flex justify-content-between">
                            <span>{{ $svc->nama }} <small class="text-muted">({{ ucfirst($svc->tipe) }})</small></span>
                            <span class="fw-semibold">Rp {{ number_format($svc->harga, 0, ",", ".") }}</span>
                        </label>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>

    <div class="d-flex gap-2">
        <button type="submit" class="btn btn-primary"><i class="bi bi-save"></i> Update</button>
        <a href="{{ route("orders.index") }}" class="btn btn-outline-secondary">Batal</a>
    </div>
</form>
@endsection
