@extends('layouts.app')

@section('content')
<style>
    @import url('https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap');

    .holidays-page {
        font-family: 'Inter', sans-serif;
        padding: 2rem 1.5rem 4rem;
        max-width: 1100px;
        margin: 0 auto;
        color: #1e293b;
    }

    /* ── Flash Messages ── */
    .holidays-flash {
        padding: 0.85rem 1.25rem;
        border-radius: 12px;
        font-size: 0.875rem;
        font-weight: 500;
        margin-bottom: 1.5rem;
        display: flex;
        align-items: center;
        gap: 0.6rem;
        animation: fadeUp 0.5s ease both;
    }
    .holidays-flash.success {
        background: linear-gradient(135deg, #ecfdf5, #d1fae5);
        color: #065f46;
        border: 1px solid #a7f3d0;
    }
    .holidays-flash.error {
        background: linear-gradient(135deg, #fef2f2, #fee2e2);
        color: #991b1b;
        border: 1px solid #fca5a5;
    }

    /* ── Page Header ── */
    .holidays-header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        flex-wrap: wrap;
        gap: 1rem;
        margin-bottom: 2rem;
        animation: fadeUp 0.45s ease both;
    }
    .holidays-header-left h1 {
        font-size: 1.85rem;
        font-weight: 800;
        color: #0f172a;
        margin: 0 0 0.2rem;
        letter-spacing: -0.5px;
    }
    .holidays-header-left p {
        margin: 0;
        font-size: 0.9rem;
        color: #64748b;
        font-weight: 400;
    }
    .holidays-add-btn {
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        padding: 0.7rem 1.5rem;
        background: linear-gradient(135deg, #6366f1, #4f46e5);
        color: #fff;
        border: none;
        border-radius: 12px;
        font-family: 'Inter', sans-serif;
        font-size: 0.875rem;
        font-weight: 600;
        text-decoration: none;
        cursor: pointer;
        transition: all 0.25s ease;
        box-shadow: 0 4px 14px rgba(99, 102, 241, 0.35);
    }
    .holidays-add-btn:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 20px rgba(99, 102, 241, 0.5);
        color: #fff;
        text-decoration: none;
    }
    .holidays-add-btn:active {
        transform: translateY(0);
    }

    /* ── Filter Row ── */
    .holidays-filters {
        display: flex;
        align-items: flex-end;
        gap: 1rem;
        flex-wrap: wrap;
        padding: 1.25rem 1.5rem;
        background: #fff;
        border: 1px solid #e2e8f0;
        border-radius: 16px;
        margin-bottom: 2rem;
        box-shadow: 0 1px 4px rgba(0,0,0,0.04);
        animation: fadeUp 0.5s ease both;
        animation-delay: 0.05s;
    }
    .holidays-filter-group {
        display: flex;
        flex-direction: column;
        gap: 0.35rem;
    }
    .holidays-filter-group label {
        font-size: 0.75rem;
        font-weight: 600;
        color: #64748b;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }
    .holidays-filter-group input,
    .holidays-filter-group select {
        font-family: 'Inter', sans-serif;
        font-size: 0.875rem;
        padding: 0.55rem 0.9rem;
        border: 1.5px solid #e2e8f0;
        border-radius: 10px;
        color: #1e293b;
        background: #f8fafc;
        transition: all 0.2s ease;
        min-width: 140px;
        outline: none;
    }
    .holidays-filter-group input:focus,
    .holidays-filter-group select:focus {
        border-color: #818cf8;
        box-shadow: 0 0 0 3px rgba(129, 140, 248, 0.15);
        background: #fff;
    }
    .holidays-filter-btn {
        padding: 0.55rem 1.25rem;
        background: linear-gradient(135deg, #6366f1, #4f46e5);
        color: #fff;
        border: none;
        border-radius: 10px;
        font-family: 'Inter', sans-serif;
        font-size: 0.85rem;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.2s ease;
        display: inline-flex;
        align-items: center;
        gap: 0.4rem;
    }
    .holidays-filter-btn:hover {
        box-shadow: 0 4px 12px rgba(99,102,241,0.35);
        transform: translateY(-1px);
    }
    .holidays-filter-reset {
        padding: 0.55rem 1rem;
        background: #f1f5f9;
        color: #64748b;
        border: 1.5px solid #e2e8f0;
        border-radius: 10px;
        font-family: 'Inter', sans-serif;
        font-size: 0.85rem;
        font-weight: 500;
        text-decoration: none;
        transition: all 0.2s ease;
        display: inline-flex;
        align-items: center;
        gap: 0.35rem;
    }
    .holidays-filter-reset:hover {
        background: #e2e8f0;
        color: #475569;
        text-decoration: none;
    }

    /* ── Stats Bar ── */
    .holidays-stats {
        display: flex;
        gap: 0.75rem;
        flex-wrap: wrap;
        margin-bottom: 1.75rem;
        animation: fadeUp 0.55s ease both;
        animation-delay: 0.1s;
    }
    .holidays-stat-chip {
        display: inline-flex;
        align-items: center;
        gap: 0.4rem;
        padding: 0.4rem 0.85rem;
        border-radius: 20px;
        font-size: 0.78rem;
        font-weight: 600;
        background: #f1f5f9;
        color: #475569;
        border: 1px solid #e2e8f0;
    }
    .holidays-stat-chip .stat-dot {
        width: 8px;
        height: 8px;
        border-radius: 50%;
    }
    .stat-dot-national { background: #ef4444; }
    .stat-dot-regional { background: #3b82f6; }
    .stat-dot-company { background: #22c55e; }
    .stat-dot-optional { background: #94a3b8; }
    .stat-dot-total { background: #6366f1; }

    /* ── Timeline / Card List ── */
    .holidays-timeline {
        position: relative;
        padding-left: 0;
    }

    .holiday-card {
        display: flex;
        align-items: stretch;
        background: #fff;
        border: 1px solid #e2e8f0;
        border-radius: 16px;
        margin-bottom: 0.85rem;
        overflow: hidden;
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        box-shadow: 0 1px 3px rgba(0,0,0,0.04);
        animation: fadeUp 0.5s ease both;
    }
    .holiday-card:hover {
        transform: translateY(-3px);
        box-shadow: 0 8px 25px rgba(0,0,0,0.08);
        border-color: #c7d2fe;
    }

    /* Date Badge */
    .holiday-date-badge {
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        min-width: 82px;
        padding: 1rem 0.75rem;
        color: #fff;
        text-align: center;
        flex-shrink: 0;
    }
    .holiday-date-badge .date-month {
        font-size: 0.7rem;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 1px;
        opacity: 0.9;
    }
    .holiday-date-badge .date-day {
        font-size: 1.65rem;
        font-weight: 800;
        line-height: 1.1;
    }
    .holiday-date-badge .date-weekday {
        font-size: 0.65rem;
        font-weight: 500;
        opacity: 0.8;
        margin-top: 2px;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    /* Type-based gradient backgrounds */
    .date-bg-national {
        background: linear-gradient(135deg, #ef4444, #dc2626);
    }
    .date-bg-regional {
        background: linear-gradient(135deg, #3b82f6, #2563eb);
    }
    .date-bg-company {
        background: linear-gradient(135deg, #22c55e, #16a34a);
    }
    .date-bg-optional {
        background: linear-gradient(135deg, #94a3b8, #64748b);
    }

    /* Card Body */
    .holiday-card-body {
        flex: 1;
        padding: 1rem 1.25rem;
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 1rem;
        min-width: 0;
    }
    .holiday-info {
        flex: 1;
        min-width: 0;
    }
    .holiday-name {
        font-size: 1rem;
        font-weight: 700;
        color: #0f172a;
        margin: 0 0 0.3rem;
        display: flex;
        align-items: center;
        gap: 0.5rem;
        flex-wrap: wrap;
    }
    .holiday-description {
        font-size: 0.825rem;
        color: #64748b;
        margin: 0;
        line-height: 1.5;
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }
    .holiday-meta {
        display: flex;
        align-items: center;
        gap: 0.5rem;
        margin-top: 0.45rem;
        flex-wrap: wrap;
    }

    /* Badges */
    .holiday-type-badge {
        display: inline-flex;
        align-items: center;
        gap: 0.3rem;
        padding: 0.2rem 0.65rem;
        border-radius: 20px;
        font-size: 0.7rem;
        font-weight: 600;
        text-transform: capitalize;
        letter-spacing: 0.3px;
    }
    .badge-national {
        background: #fef2f2;
        color: #dc2626;
        border: 1px solid #fecaca;
    }
    .badge-regional {
        background: #eff6ff;
        color: #2563eb;
        border: 1px solid #bfdbfe;
    }
    .badge-company {
        background: #f0fdf4;
        color: #16a34a;
        border: 1px solid #bbf7d0;
    }
    .badge-optional {
        background: #f8fafc;
        color: #64748b;
        border: 1px solid #e2e8f0;
    }

    .holiday-status {
        display: inline-flex;
        align-items: center;
        gap: 0.25rem;
        padding: 0.2rem 0.6rem;
        border-radius: 20px;
        font-size: 0.7rem;
        font-weight: 600;
    }
    .status-active {
        background: #f0fdf4;
        color: #16a34a;
        border: 1px solid #bbf7d0;
    }
    .status-inactive {
        background: #fef2f2;
        color: #dc2626;
        border: 1px solid #fecaca;
    }
    .status-dot {
        width: 6px;
        height: 6px;
        border-radius: 50%;
    }
    .status-dot-active { background: #22c55e; }
    .status-dot-inactive { background: #ef4444; }

    /* Actions */
    .holiday-actions {
        display: flex;
        align-items: center;
        gap: 0.4rem;
        flex-shrink: 0;
    }
    .holiday-action-btn {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        width: 36px;
        height: 36px;
        border-radius: 10px;
        border: 1.5px solid #e2e8f0;
        background: #f8fafc;
        color: #64748b;
        font-size: 0.95rem;
        cursor: pointer;
        transition: all 0.2s ease;
        text-decoration: none;
    }
    .holiday-action-btn:hover {
        border-color: #c7d2fe;
        color: #4f46e5;
        background: #eef2ff;
        transform: translateY(-1px);
        text-decoration: none;
    }
    .holiday-action-btn.delete-btn:hover {
        border-color: #fca5a5;
        color: #dc2626;
        background: #fef2f2;
    }

    /* ── Empty State ── */
    .holidays-empty {
        text-align: center;
        padding: 4rem 2rem;
        animation: fadeUp 0.5s ease both;
    }
    .holidays-empty-icon {
        width: 80px;
        height: 80px;
        border-radius: 50%;
        background: linear-gradient(135deg, #eef2ff, #e0e7ff);
        display: inline-flex;
        align-items: center;
        justify-content: center;
        font-size: 2rem;
        color: #6366f1;
        margin-bottom: 1.25rem;
    }
    .holidays-empty h3 {
        font-size: 1.15rem;
        font-weight: 700;
        color: #1e293b;
        margin: 0 0 0.4rem;
    }
    .holidays-empty p {
        font-size: 0.875rem;
        color: #94a3b8;
        margin: 0 0 1.5rem;
    }

    /* ── Animations ── */
    @keyframes fadeUp {
        from {
            opacity: 0;
            transform: translateY(16px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    /* Staggered card animation */
    .holiday-card:nth-child(1) { animation-delay: 0.05s; }
    .holiday-card:nth-child(2) { animation-delay: 0.1s; }
    .holiday-card:nth-child(3) { animation-delay: 0.15s; }
    .holiday-card:nth-child(4) { animation-delay: 0.2s; }
    .holiday-card:nth-child(5) { animation-delay: 0.25s; }
    .holiday-card:nth-child(6) { animation-delay: 0.3s; }
    .holiday-card:nth-child(7) { animation-delay: 0.35s; }
    .holiday-card:nth-child(8) { animation-delay: 0.4s; }
    .holiday-card:nth-child(9) { animation-delay: 0.45s; }
    .holiday-card:nth-child(10) { animation-delay: 0.5s; }

    /* ── Delete Modal ── */
    .holidays-modal-overlay {
        display: none;
        position: fixed;
        inset: 0;
        background: rgba(15, 23, 42, 0.4);
        backdrop-filter: blur(4px);
        z-index: 9999;
        align-items: center;
        justify-content: center;
    }
    .holidays-modal-overlay.active {
        display: flex;
    }
    .holidays-modal {
        background: #fff;
        border-radius: 20px;
        padding: 2rem;
        max-width: 420px;
        width: 90%;
        text-align: center;
        box-shadow: 0 25px 60px rgba(0,0,0,0.15);
        animation: fadeUp 0.3s ease both;
    }
    .holidays-modal-icon {
        width: 56px;
        height: 56px;
        border-radius: 50%;
        background: #fef2f2;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        font-size: 1.5rem;
        color: #ef4444;
        margin-bottom: 1rem;
    }
    .holidays-modal h3 {
        font-size: 1.1rem;
        font-weight: 700;
        color: #0f172a;
        margin: 0 0 0.35rem;
    }
    .holidays-modal p {
        font-size: 0.85rem;
        color: #64748b;
        margin: 0 0 1.5rem;
    }
    .holidays-modal-actions {
        display: flex;
        gap: 0.75rem;
        justify-content: center;
    }
    .holidays-modal-cancel {
        padding: 0.6rem 1.25rem;
        border-radius: 10px;
        border: 1.5px solid #e2e8f0;
        background: #f8fafc;
        color: #475569;
        font-family: 'Inter', sans-serif;
        font-size: 0.85rem;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.2s ease;
    }
    .holidays-modal-cancel:hover {
        background: #e2e8f0;
    }
    .holidays-modal-delete {
        padding: 0.6rem 1.25rem;
        border-radius: 10px;
        border: none;
        background: linear-gradient(135deg, #ef4444, #dc2626);
        color: #fff;
        font-family: 'Inter', sans-serif;
        font-size: 0.85rem;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.2s ease;
        box-shadow: 0 4px 12px rgba(239, 68, 68, 0.3);
    }
    .holidays-modal-delete:hover {
        box-shadow: 0 6px 18px rgba(239, 68, 68, 0.45);
        transform: translateY(-1px);
    }

    /* ── Responsive ── */
    @media (max-width: 640px) {
        .holidays-page { padding: 1.25rem 1rem 3rem; }
        .holidays-header { flex-direction: column; align-items: flex-start; }
        .holiday-card { flex-direction: column; }
        .holiday-date-badge {
            flex-direction: row;
            min-width: unset;
            padding: 0.65rem 1rem;
            gap: 0.5rem;
        }
        .holiday-date-badge .date-day { font-size: 1.25rem; }
        .holiday-card-body { flex-direction: column; align-items: flex-start; }
        .holiday-actions { align-self: flex-end; }
    }
</style>

<div class="holidays-page">

    {{-- Flash Messages --}}
    @if(session('success'))
        <div class="holidays-flash success">
            <i class="bi bi-check-circle-fill"></i>
            {{ session('success') }}
        </div>
    @endif
    @if(session('error'))
        <div class="holidays-flash error">
            <i class="bi bi-exclamation-triangle-fill"></i>
            {{ session('error') }}
        </div>
    @endif

    {{-- Page Header --}}
    <div class="holidays-header">
        <div class="holidays-header-left">
            <h1><i class="bi bi-calendar2-heart" style="color:#6366f1;margin-right:6px;"></i> Holidays</h1>
            <p>Manage company holidays and observances for {{ $year }}</p>
        </div>
        <a href="{{ route('admin.holidays.create') }}" class="holidays-add-btn">
            <i class="bi bi-plus-lg"></i> Add Holiday
        </a>
    </div>

    {{-- Filter Row --}}
    <form method="GET" action="{{ route('admin.holidays.index') }}" class="holidays-filters">
        <div class="holidays-filter-group">
            <label for="filter-year">Year</label>
            <input type="number" id="filter-year" name="year" value="{{ $year }}" min="2000" max="2099" style="width:120px;">
        </div>
        <div class="holidays-filter-group">
            <label for="filter-type">Type</label>
            <select id="filter-type" name="type">
                <option value="">All Types</option>
                <option value="national" {{ request('type') === 'national' ? 'selected' : '' }}>National</option>
                <option value="regional" {{ request('type') === 'regional' ? 'selected' : '' }}>Regional</option>
                <option value="company" {{ request('type') === 'company' ? 'selected' : '' }}>Company</option>
                <option value="optional" {{ request('type') === 'optional' ? 'selected' : '' }}>Optional</option>
            </select>
        </div>
        <button type="submit" class="holidays-filter-btn">
            <i class="bi bi-funnel"></i> Filter
        </button>
        <a href="{{ route('admin.holidays.index') }}" class="holidays-filter-reset">
            <i class="bi bi-arrow-counterclockwise"></i> Reset
        </a>
    </form>

    {{-- Stats Bar --}}
    @if($holidays->count() > 0)
    <div class="holidays-stats">
        <span class="holidays-stat-chip">
            <span class="stat-dot stat-dot-total"></span>
            {{ $holidays->count() }} Total
        </span>
        @if($holidays->where('type', 'national')->count() > 0)
        <span class="holidays-stat-chip">
            <span class="stat-dot stat-dot-national"></span>
            {{ $holidays->where('type', 'national')->count() }} National
        </span>
        @endif
        @if($holidays->where('type', 'regional')->count() > 0)
        <span class="holidays-stat-chip">
            <span class="stat-dot stat-dot-regional"></span>
            {{ $holidays->where('type', 'regional')->count() }} Regional
        </span>
        @endif
        @if($holidays->where('type', 'company')->count() > 0)
        <span class="holidays-stat-chip">
            <span class="stat-dot stat-dot-company"></span>
            {{ $holidays->where('type', 'company')->count() }} Company
        </span>
        @endif
        @if($holidays->where('type', 'optional')->count() > 0)
        <span class="holidays-stat-chip">
            <span class="stat-dot stat-dot-optional"></span>
            {{ $holidays->where('type', 'optional')->count() }} Optional
        </span>
        @endif
    </div>
    @endif

    {{-- Holiday Cards --}}
    @if($holidays->count() > 0)
    <div class="holidays-timeline">
        @foreach($holidays as $holiday)
        <div class="holiday-card">
            {{-- Date Badge --}}
            <div class="holiday-date-badge date-bg-{{ $holiday->type }}">
                <span class="date-month">{{ $holiday->date->format('M') }}</span>
                <span class="date-day">{{ $holiday->date->format('d') }}</span>
                <span class="date-weekday">{{ $holiday->date->format('D') }}</span>
            </div>

            {{-- Card Body --}}
            <div class="holiday-card-body">
                <div class="holiday-info">
                    <h4 class="holiday-name">{{ $holiday->name }}</h4>
                    @if($holiday->description)
                        <p class="holiday-description">{{ $holiday->description }}</p>
                    @endif
                    <div class="holiday-meta">
                        <span class="holiday-type-badge badge-{{ $holiday->type }}">
                            @switch($holiday->type)
                                @case('national')
                                    <i class="bi bi-flag-fill"></i>
                                    @break
                                @case('regional')
                                    <i class="bi bi-geo-alt-fill"></i>
                                    @break
                                @case('company')
                                    <i class="bi bi-building"></i>
                                    @break
                                @case('optional')
                                    <i class="bi bi-bookmark"></i>
                                    @break
                            @endswitch
                            {{ $holiday->type }}
                        </span>
                        @if($holiday->is_active)
                            <span class="holiday-status status-active">
                                <span class="status-dot status-dot-active"></span> Active
                            </span>
                        @else
                            <span class="holiday-status status-inactive">
                                <span class="status-dot status-dot-inactive"></span> Inactive
                            </span>
                        @endif
                        <span style="font-size:0.75rem;color:#94a3b8;font-weight:500;">
                            {{ $holiday->date->format('l, F j, Y') }}
                        </span>
                    </div>
                </div>

                {{-- Actions --}}
                <div class="holiday-actions">
                    <a href="{{ route('admin.holidays.edit', $holiday->id) }}" class="holiday-action-btn" title="Edit">
                        <i class="bi bi-pencil"></i>
                    </a>
                    <button type="button" class="holiday-action-btn delete-btn" title="Delete"
                        onclick="openDeleteModal('{{ $holiday->id }}', '{{ addslashes($holiday->name) }}')">
                        <i class="bi bi-trash3"></i>
                    </button>
                </div>
            </div>
        </div>
        @endforeach
    </div>
    @else
    {{-- Empty State --}}
    <div class="holidays-empty">
        <div class="holidays-empty-icon">
            <i class="bi bi-calendar2-x"></i>
        </div>
        <h3>No Holidays Found</h3>
        <p>There are no holidays configured for {{ $year }}{{ request('type') ? ' with type "' . request('type') . '"' : '' }}. Add one to get started!</p>
        <a href="{{ route('admin.holidays.create') }}" class="holidays-add-btn">
            <i class="bi bi-plus-lg"></i> Add Holiday
        </a>
    </div>
    @endif
</div>

{{-- Delete Confirmation Modal --}}
<div class="holidays-modal-overlay" id="deleteModal">
    <div class="holidays-modal">
        <div class="holidays-modal-icon">
            <i class="bi bi-trash3"></i>
        </div>
        <h3>Delete Holiday</h3>
        <p>Are you sure you want to delete <strong id="deleteHolidayName"></strong>? This action cannot be undone.</p>
        <div class="holidays-modal-actions">
            <button type="button" class="holidays-modal-cancel" onclick="closeDeleteModal()">Cancel</button>
            <form id="deleteForm" method="POST" style="display:inline;">
                @csrf
                @method('DELETE')
                <button type="submit" class="holidays-modal-delete">
                    <i class="bi bi-trash3"></i> Delete
                </button>
            </form>
        </div>
    </div>
</div>

<script>
    function openDeleteModal(id, name) {
        document.getElementById('deleteHolidayName').textContent = name;
        document.getElementById('deleteForm').action = '{{ url("admin/holidays") }}/' + id;
        document.getElementById('deleteModal').classList.add('active');
    }

    function closeDeleteModal() {
        document.getElementById('deleteModal').classList.remove('active');
    }

    // Close modal on overlay click
    document.getElementById('deleteModal').addEventListener('click', function(e) {
        if (e.target === this) closeDeleteModal();
    });

    // Close modal on Escape key
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape') closeDeleteModal();
    });
</script>
@endsection
