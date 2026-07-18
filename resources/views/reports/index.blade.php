@extends("layouts.admin")
@section("title", "Laporan")
@section("page_title", "Laporan")

@section("content")
{{-- Filter --}}
<div class="card mb-3">
    <div class="card-body">
        <form action="{{ route("reports") }}" method="GET" class="row g-2">
            <div class="col-md-3">
                <label class="form-label">Dari Tanggal</label>
                <input type="date" name="from" class="form-control" value="{{ request("from", $from) }}">
            </div>
            <div class="col-md-3">
                <label class="form-label">Sampai Tanggal</label>
                <input type="date" name="to" class="form-control" value="{{ request("to", $to) }}">
            </div>
            <div class="col-md-3 d-flex align-items-end">
                <button type="submit" class="btn btn-primary me-2"><i class="bi bi-funnel"></i> Tampilkan</button>
                <a href="{{ route("reports") }}" class="btn btn-outline-secondary">Reset</a>
            </div>
        </form>
    </div>
</div>

{{-- Statistik --}}
<div class="row mb-4">
    <div class="col-md-4 mb-3">
        <div class="stat-card">
            <div class="d-flex justify-content-between align-items-start">
                <div>
                    <div class="label">Total Order</div>
                    <div class="value">{{ $totalOrders }}</div>
                </div>
                <div class="icon bg-primary bg-opacity-10 text-primary">
                    <i class="bi bi-receipt"></i>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-4 mb-3">
        <div class="stat-card">
            <div class="d-flex justify-content-between align-items-start">
                <div>
                    <div class="label">Total Pendapatan</div>
                    <div class="value" style="font-size:1.4rem">Rp {{ number_format($totalRevenue, 0, ",", ".") }}</div>
                </div>
                <div class="icon bg-success bg-opacity-10 text-success">
                    <i class="bi bi-cash-stack"></i>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-4 mb-3">
        <div class="stat-card">
            <div class="d-flex justify-content-between align-items-start">
                <div>
                    <div class="label">Rata-rata per Order</div>
                    <div class="value" style="font-size:1.4rem">Rp {{ number_format($avgOrder, 0, ",", ".") }}</div>
                </div>
                <div class="icon bg-warning bg-opacity-10 text-warning">
                    <i class="bi bi-graph-up-arrow"></i>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- Chart --}}
<div class="card mb-3">
    <div class="card-header"><i class="bi bi-bar-chart me-1"></i> Grafik Pendapatan</div>
    <div class="card-body">
        <canvas id="revenueChart" height="100"></canvas>
    </div>
</div>

{{-- Tabel Detail --}}
<div class="card">
    <div class="card-header d-flex justify-content-between">
        <span><i class="bi bi-table me-1"></i> Detail Transaksi</span>
        <span class="text-muted small">{{ count($orders) }} transaksi</span>
    </div>
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover mb-0">
                <thead>
                    <tr>
                        <th>Tanggal</th>
                        <th>No. Order</th>
                        <th>Pelanggan</th>
                        <th>Status</th>
                        <th class="text-end">Total</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($orders as $o)
                    <tr>
                        <td class="small">{{ $o->tgl_masuk->format("d/m/Y") }}</td>
                        <td class="fw-semibold">{{ $o->no_order }}</td>
                        <td>{{ $o->customer->nama }}</td>
                        <td><span class="badge bg-{{ $o->status_color }}">{{ $o->status_label }}</span></td>
                        <td class="fw-semibold text-end">Rp {{ number_format($o->total_harga, 0, ",", ".") }}</td>
                    </tr>
                    @empty
                    <tr><td colspan="5" class="text-center py-4">Tidak ada data untuk periode ini.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection

@push("scripts")
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.1/dist/chart.umd.min.js"></script>
<script>
const ctx = document.getElementById("revenueChart").getContext("2d");
new Chart(ctx, {
    type: "line",
    data: {
        labels: @json($chartLabels),
        datasets: [{
            label: "Pendapatan",
            data: @json($chartData),
            borderColor: "#1a237e",
            backgroundColor: "rgba(26, 35, 126, 0.1)",
            fill: true,
            tension: 0.4,
        }]
    },
    options: {
        responsive: true,
        plugins: { legend: { display: false } },
        scales: {
            y: {
                beginAtZero: true,
                ticks: { callback: v => "Rp " + v.toLocaleString("id-ID") }
            }
        }
    }
});
</script>
@endpush
