@extends("layouts.admin")
@section("title", "Dashboard")
@section("page_title", "Dashboard")

@section("content")
<div class="row mb-4">
    <div class="col-xl-3 col-md-6 mb-3">
        <div class="stat-card">
            <div class="d-flex justify-content-between align-items-start">
                <div>
                    <div class="label">Total Pelanggan</div>
                    <div class="value">{{ $totalPelanggan }}</div>
                </div>
                <div class="icon bg-primary bg-opacity-10 text-primary">
                    <i class="bi bi-people"></i>
                </div>
            </div>
            <div class="mt-2 small text-muted">
                <i class="bi bi-person-plus"></i> {{ $pelangganBaru }} baru bulan ini
            </div>
        </div>
    </div>
    <div class="col-xl-3 col-md-6 mb-3">
        <div class="stat-card">
            <div class="d-flex justify-content-between align-items-start">
                <div>
                    <div class="label">Order Hari Ini</div>
                    <div class="value">{{ $orderHariIni }}</div>
                </div>
                <div class="icon bg-info bg-opacity-10 text-info">
                    <i class="bi bi-receipt"></i>
                </div>
            </div>
            <div class="mt-2 small text-muted">
                @if($orderHariIni > 0)
                    <i class="bi bi-check-circle text-success"></i> Aktif
                @else
                    <i class="bi bi-dash-circle"></i> Belum ada
                @endif
            </div>
        </div>
    </div>
    <div class="col-xl-3 col-md-6 mb-3">
        <div class="stat-card">
            <div class="d-flex justify-content-between align-items-start">
                <div>
                    <div class="label">Dalam Proses</div>
                    <div class="value">{{ $orderProses }}</div>
                </div>
                <div class="icon bg-warning bg-opacity-10 text-warning">
                    <i class="bi bi-arrow-repeat"></i>
                </div>
            </div>
            <div class="mt-2 small text-muted">
                <i class="bi bi-hourglass-split"></i> {{ $orderSiap }} siap diambil
            </div>
        </div>
    </div>
    <div class="col-xl-3 col-md-6 mb-3">
        <div class="stat-card">
            <div class="d-flex justify-content-between align-items-start">
                <div>
                    <div class="label">Pendapatan Hari Ini</div>
                    <div class="value" style="font-size:1.4rem">Rp {{ number_format($pendapatanHariIni, 0, ",", ".") }}</div>
                </div>
                <div class="icon bg-success bg-opacity-10 text-success">
                    <i class="bi bi-cash-stack"></i>
                </div>
            </div>
            <div class="mt-2 small text-muted">
                <i class="bi bi-graph-up"></i> Rp {{ number_format($pendapatanBulanIni, 0, ",", ".") }} bulan ini
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-8">
        <div class="card mb-3">
            <div class="card-header d-flex justify-content-between">
                <span><i class="bi bi-graph-up me-1"></i> Pendapatan 7 Hari Terakhir</span>
                <a href="{{ route("reports") }}" class="btn btn-sm btn-outline-primary">Laporan <i class="bi bi-arrow-right"></i></a>
            </div>
            <div class="card-body">
                <canvas id="weeklyChart" height="80"></canvas>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card mb-3">
            <div class="card-header"><i class="bi bi-clock me-1"></i> Order Terbaru</div>
            <div class="card-body p-0">
                <div class="list-group list-group-flush">
                    @forelse($ordersTerbaru as $o)
                    <a href="{{ route("orders.show", $o) }}" class="list-group-item list-group-item-action">
                        <div class="d-flex justify-content-between">
                            <span class="fw-semibold small">{{ $o->no_order }}</span>
                            <span class="badge bg-{{ $o->status_color }} badge-status">{{ $o->status_label }}</span>
                        </div>
                        <div class="small text-muted">{{ $o->customer->nama }} - Rp {{ number_format($o->total_harga, 0, ",", ".") }}</div>
                    </a>
                    @empty
                    <div class="list-group-item text-muted text-center py-4">Belum ada order</div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push("scripts")
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.1/dist/chart.umd.min.js"></script>
<script>
const ctx = document.getElementById("weeklyChart").getContext("2d");
new Chart(ctx, {
    type: "bar",
    data: {
        labels: @json($chartLabels),
        datasets: [{
            label: "Pendapatan",
            data: @json($chartData),
            backgroundColor: [
                "#c5cae9","#9fa8da","#7986cb","#5c6bc0","#3f51b5","#3949ab","#1a237e"
            ],
            borderRadius: 4,
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
