@extends("layouts.admin")

@section("title", "Activity Log")

@section("page_title", "Activity Log")

@section("styles")
<style>
    .log-entry { transition: background-color 0.15s; }
    .log-entry:hover { background-color: #f8f9fa; }
    .log-action { font-size: 0.75rem; font-weight: 600; text-transform: uppercase; letter-spacing: 0.04em; }
    .log-time { font-size: 0.8rem; color: #6c757d; }
    .log-desc { font-weight: 500; }
    .filter-card { background: #fff; border-radius: 12px; border: 1px solid #e9ecef; padding: 1.25rem; margin-bottom: 1.5rem; }
</style>
@endsection

@section("content")
<div class="filter-card">
    <form method="GET" action="{{ route("activity-logs.index") }}" class="row g-3 align-items-end">
        <div class="col-md-4">
            <label class="form-label small fw-semibold">Tipe Aksi</label>
            <select name="action" class="form-select">
                <option value="">Semua Aksi</option>
                @foreach($actionTypes as $type)
                    <option value="{{ $type }}" {{ request("action") == $type ? "selected" : "" }}>
                        {{ ucfirst($type) }}
                    </option>
                @endforeach
            </select>
        </div>
        <div class="col-md-4">
            <label class="form-label small fw-semibold">Tipe Subjek</label>
            <select name="subject_type" class="form-select">
                <option value="">Semua Subjek</option>
                @foreach($subjectTypes as $type)
                    <option value="{{ $type }}" {{ request("subject_type") == $type ? "selected" : "" }}>
                        {{ $type }}
                    </option>
                @endforeach
            </select>
        </div>
        <div class="col-md-4">
            <button type="submit" class="btn btn-primary w-100">
                <i class="bi bi-funnel"></i> Filter
            </button>
        </div>
    </form>
</div>

<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <span><i class="bi bi-clock-history me-1"></i> Riwayat Aktivitas</span>
        <span class="badge bg-secondary">{{ $logs->total() }} total</span>
    </div>
    <div class="card-body p-0">
        @if($logs->count())
            <div class="table-responsive">
                <table class="table table-hover mb-0">
                    <thead>
                        <tr>
                            <th>Waktu</th>
                            <th>Actor</th>
                            <th>Aksi</th>
                            <th>Subjek</th>
                            <th>Deskripsi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($logs as $log)
                            <tr class="log-entry">
                                <td class="log-time">
                                    <i class="bi bi-clock me-1"></i>
                                    {{ $log->created_at->timezone("Asia/Jakarta")->format("d/m/Y H:i") }}
                                </td>
                                <td>
                                    @if($log->actor)
                                        <span class="fw-medium">{{ $log->actor->name }}</span>
                                        <span class="badge bg-light text-dark ms-1">{{ $log->actor->role }}</span>
                                    @else
                                        <span class="text-muted fst-italic">System</span>
                                    @endif
                                </td>
                                <td>
                                    @php
                                        $badgeClass = match($log->action) {
                                            "created" => "bg-success",
                                            "updated" => "bg-primary",
                                            "deleted" => "bg-danger",
                                            default => "bg-secondary",
                                        };
                                    @endphp
                                    <span class="badge {{ $badgeClass }} log-action">{{ $log->action }}</span>
                                </td>
                                <td>
                                    <span class="fw-medium">{{ class_basename($log->subject_type) }}</span>
                                    <span class="text-muted">#{{ $log->subject_id }}</span>
                                </td>
                                <td class="log-desc">{{ $log->description }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class="p-3">
                {{ $logs->withQueryString()->links() }}
            </div>
        @else
            <div class="text-center py-5 text-muted">
                <i class="bi bi-inbox" style="font-size: 2rem;"></i>
                <p class="mt-2 mb-0">Belum ada aktivitas tercatat.</p>
            </div>
        @endif
    </div>
</div>
@endsection
