@extends("layouts.admin")
@section("title", "Transaksi Baru")
@section("page_title", "Transaksi Baru")

@section("content")
<form action="{{ route("orders.store") }}" method="POST">
    @csrf

    <div class="row">
        {{-- Pilih Pelanggan --}}
        <div class="col-md-4">
            <div class="card mb-3">
                <div class="card-header"><i class="bi bi-person me-1"></i> Data Pelanggan</div>
                <div class="card-body">
                    <div class="mb-3">
                        <label class="form-label">Pelanggan <span class="text-danger">*</span></label>
                        <select name="customer_id" class="form-select @error("customer_id") is-invalid @enderror" required>
                            <option value="">-- Pilih Pelanggan --</option>
                            @foreach($customers as $c)
                                <option value="{{ $c->id }}" {{ old("customer_id") == $c->id ? "selected" : "" }}>
                                    {{ $c->nama }} - {{ $c->no_telp }}
                                </option>
                            @endforeach
                        </select>
                        @error("customer_id") <div class="invalid-feedback">{{ $message }}</div> @enderror
                        <div class="mt-2">
                            <a href="{{ route("customers.create") }}" target="_blank" class="small">
                                <i class="bi bi-plus-circle"></i> Pelanggan baru
                            </a>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Tanggal Masuk <span class="text-danger">*</span></label>
                        <input type="date" name="tgl_masuk" class="form-control @error("tgl_masuk") is-invalid @enderror" value="{{ old("tgl_masuk", date("Y-m-d")) }}" required>
                        @error("tgl_masuk") <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Catatan</label>
                        <textarea name="catatan" class="form-control" rows="3">{{ old("catatan") }}</textarea>
                    </div>
                </div>
            </div>
        </div>

        {{-- Item Layanan --}}
        <div class="col-md-8">
            <div class="card mb-3">
                <div class="card-header">
                    <i class="bi bi-cart me-1"></i> Item Layanan
                    <button type="button" class="btn btn-sm btn-outline-primary float-end" onclick="tambahItem()">
                        <i class="bi bi-plus-lg"></i> Tambah Item
                    </button>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered" id="items-table">
                            <thead class="table-light">
                                <tr>
                                    <th>Layanan</th>
                                    <th style="width:100px">Tipe</th>
                                    <th style="width:120px">Berat (kg)</th>
                                    <th style="width:90px">Jumlah</th>
                                    <th style="width:130px">Harga</th>
                                    <th style="width:130px">Subtotal</th>
                                    <th style="width:40px"></th>
                                </tr>
                            </thead>
                            <tbody id="items-container"></tbody>
                            <tfoot>
                                <tr class="table-active">
                                    <th colspan="4" class="text-end">Total:</th>
                                    <th id="total-display" class="fw-bold">Rp 0</th>
                                    <th></th>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>

            <div class="d-flex gap-2">
                <button type="submit" class="btn btn-primary btn-lg">
                    <i class="bi bi-check-lg"></i> Simpan Transaksi
                </button>
                <a href="{{ route("orders.index") }}" class="btn btn-outline-secondary btn-lg">Batal</a>
            </div>
        </div>
    </div>
</form>
@endsection

@push("scripts")
<script>
const services = @json($services);

function tambahItem(data = null) {
    const container = document.getElementById("items-container");
    const idx = container.children.length;
    const row = document.createElement("tr");

    const svcOpts = services.map(s =>
        `<option value="${s.id}" data-tipe="${s.tipe}" data-harga="${s.harga}" ${data && data.service_id == s.id ? "selected" : ""}>
            ${s.nama} (Rp ${Number(s.harga).toLocaleString("id-ID")})
        </option>`
    ).join("");

    row.innerHTML = `
        <td>
            <select name="items[${idx}][service_id]" class="form-select form-select-sm service-select" required onchange="updateItem(this)">
                <option value="">-- Pilih --</option>
                ${svcOpts}
            </select>
        </td>
        <td class="tipe-display">${data ? data.jenis : "-"}</td>
        <td>
            <input type="number" name="items[${idx}][berat]" class="form-control form-control-sm berat-input" step="0.5" min="0.5" value="${data ? (data.berat || "") : ""}" oninput="hitungSubtotal(this)">
        </td>
        <td>
            <input type="number" name="items[${idx}][jumlah]" class="form-control form-control-sm jumlah-input" min="1" value="${data ? (data.jumlah || 1) : 1}" oninput="hitungSubtotal(this)">
        </td>
        <td>
            <div class="input-group input-group-sm">
                <span class="input-group-text">Rp</span>
                <input type="number" name="items[${idx}][harga]" class="form-control form-control-sm harga-input" readonly value="${data ? data.harga_satuan : ""}">
            </div>
        </td>
        <td>
            <div class="input-group input-group-sm">
                <span class="input-group-text">Rp</span>
                <input type="number" name="items[${idx}][subtotal]" class="form-control form-control-sm subtotal-input" readonly value="${data ? data.subtotal : "0"}">
            </div>
        </td>
        <td>
            <button type="button" class="btn btn-sm btn-outline-danger" onclick="hapusItem(this)">
                <i class="bi bi-x"></i>
            </button>
        </td>
    `;
    container.appendChild(row);

    if (data) {
        updateTotal();
    }
}

function updateItem(select) {
    const row = select.closest("tr");
    const opt = select.options[select.selectedIndex];
    const tipe = opt.dataset.tipe || "";
    const harga = opt.dataset.harga || 0;
    const tipeDisplay = row.querySelector(".tipe-display");
    const hargaInput = row.querySelector(".harga-input");
    const beratInput = row.querySelector(".berat-input");
    const jumlahInput = row.querySelector(".jumlah-input");

    tipeDisplay.textContent = tipe.charAt(0).toUpperCase() + tipe.slice(1);
    hargaInput.value = harga;

    if (tipe === "kiloan") {
        beratInput.disabled = false;
        beratInput.value = beratInput.value || "";
        jumlahInput.disabled = true;
        jumlahInput.value = 1;
    } else {
        beratInput.disabled = true;
        beratInput.value = "";
        jumlahInput.disabled = false;
    }

    hitungSubtotal(beratInput);
}

function hitungSubtotal(el) {
    const row = el.closest("tr");
    const harga = parseFloat(row.querySelector(".harga-input").value) || 0;
    const berat = parseFloat(row.querySelector(".berat-input").value) || 0;
    const jumlah = parseInt(row.querySelector(".jumlah-input").value) || 1;
    const tipeDisplay = row.querySelector(".tipe-display").textContent.toLowerCase();

    let subtotal = 0;
    if (tipeDisplay === "kiloan") {
        subtotal = harga * berat;
        row.querySelector(".jumlah-input").value = 1;
    } else {
        subtotal = harga * jumlah;
        row.querySelector(".berat-input").value = "";
    }
    row.querySelector(".subtotal-input").value = Math.round(subtotal);
    updateTotal();
}

function hapusItem(btn) {
    btn.closest("tr").remove();
    updateTotal();
}

function updateTotal() {
    let total = 0;
    document.querySelectorAll(".subtotal-input").forEach(el => {
        total += parseFloat(el.value) || 0;
    });
    document.getElementById("total-display").textContent = "Rp " + Math.round(total).toLocaleString("id-ID");
    // Add hidden total input — pastikan di form orders, bukan form lain (mis. logout)
    let totalInput = document.querySelector("input[name='total_harga']");
    const orderForm = document.querySelector("form[action$='/orders']");
    if (!totalInput || !orderForm.contains(totalInput)) {
        if (totalInput) totalInput.remove();
        totalInput = document.createElement("input");
        totalInput.type = "hidden";
        totalInput.name = "total_harga";
        orderForm.appendChild(totalInput);
    }
    totalInput.value = Math.round(total);
}

// Add first row by default
tambahItem();
</script>
@endpush
