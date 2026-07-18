@extends("layouts.admin")
@section("title", "Laporan Laba-Rugi")
@section("page_title", "Laporan Laba-Rugi")

@section("content")
<div class="card mb-3">
    <div class="card-body">
        <form action="{{ route("reports.profit-loss") }}" method="GET" class="row g-2 align-items-end">
            <div class="col-md-3">
                <label class="form-label">Dari</label>
                <input type="date" name="from" class="form-control" value="{{ $from->format("Y-m-d") }}">
            </div>
            <div class="col-md-3">
                <label class="form-label">Sampai</label>
                <input type="date" name="to" class="form-control" value="{{ $to->format("Y-m-d") }}">
            </div>
            <div class="col-auto">
                <button class="btn btn-primary"><i class="bi bi-search"></i> Tampilkan</button>
            </div>
        </form>
    </div>
</div>

<div class="row g-3 mb-4">
    <div class="col-md-3">
        <div class="card border-start border-4 border-success">
            <div class="card-body">
                <div class="text-muted small">Pendapatan</div>
                <div class="fs-4 fw-bold text-success">Rp {{ number_format($totalRevenue, 0, ",", ".") }}</div>
                <small class="text-muted">{{ $totalOrders }} transaksi</small>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card border-start border-4 border-danger">
            <div class="card-body">
                <div class="text-muted small">Pengeluaran</div>
                <div class="fs-4 fw-bold text-danger">Rp {{ number_format($totalExpenses, 0, ",", ".") }}</div>
                <small class="text-muted">{{ $expenses->count() ?? 0 }} pengeluaran</small>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card border-start border-4 {{ $netProfit >= 0 ? "border-primary" : "border-warning" }}">
            <div class="card-body">
                <div class="text-muted small">Laba / Rugi</div>
                <div class="fs-4 fw-bold {{ $netProfit >= 0 ? "text-primary" : "text-warning" }}">
                    Rp {{ number_format($netProfit, 0, ",", ".") }}
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card border-start border-4 border-info">
            <div class="card-body">
                <div class="text-muted small">Margin</div>
                <div class="fs-4 fw-bold text-info">{{ $margin }}%</div>
                <small class="text-muted">{{ $netProfit >= 0 ? "Untung" : "Rugi" }}</small>
            </div>
        </div>
    </div>
</div>

<div class="row g-3">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header"><i class="bi bi-bar-chart-line"></i> Pendapatan vs Pengeluaran</div>
            <div class="card-body">
                <canvas id="profitChart" height="200"></canvas>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card">
            <div class="card-header"><i class="bi bi-pie-chart"></i> Kategori Pengeluaran</div>
            <div class="card-body">
                <canvas id="expensePieChart" height="200"></canvas>
            </div>
        </div>
    </div>
</div>

@push("scripts")
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.7/dist/chart.umd.min.js"></script>
<script>
new Chart(document.getElementById("profitChart"), {
    type: "bar",
    data: {
        labels: @json($chartLabels),
        datasets: [
            { label: "Pendapatan", data: @json($chartRevenue), backgroundColor: "rgba(40,167,69,0.7)", borderColor: "#28a745", borderWidth: 1 },
            { label: "Pengeluaran", data: @json($chartExpense), backgroundColor: "rgba(220,53,69,0.7)", borderColor: "#dc3545", borderWidth: 1 },
        ]
    },
    options: {
        responsive: true,
        plugins: { legend: { position: "top" } },
        scales: { y: { beginAtZero: true } }
    }
});

new Chart(document.getElementById("expensePieChart"), {
    type: "pie",
    data: {
        labels: @json($expCatLabels),
        datasets: [{ data: @json($expCatValues), backgroundColor: ["#dc3545","#fd7e14","#ffc107","#20c997","#6f42c1","#0dcaf0"] }]
    },
    options: {
        responsive: true,
        plugins: { legend: { position: "bottom" } }
    }
});
</script>
@endpush
@endsection