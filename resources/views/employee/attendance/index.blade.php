@extends('layouts.app')

@section('content')
<style>
    .att-page{--primary:#06b6d4;--emerald:#10b981;--rose:#f43f5e;--amber:#f59e0b;--sky:#0ea5e9;font-family:'Inter',sans-serif;}
    .page-header{display:flex;align-items:center;justify-content:space-between;margin-bottom:24px;flex-wrap:wrap;gap:16px}
    .page-header h1{font-size:1.5rem;font-weight:800;color:#1e1b4b;display:flex;align-items:center;gap:10px;margin:0}
    .page-header h1 .h-icon{width:42px;height:42px;border-radius:14px;display:flex;align-items:center;justify-content:center;font-size:1.2rem;background:#ecfeff;color:#06b6d4}
    .month-filter{display:flex;align-items:center;gap:10px}
    .month-filter input[type="month"]{padding:10px 16px;border:2px solid #e5e7eb;border-radius:12px;font-family:'Inter',sans-serif;font-size:.9rem;font-weight:600;color:#374151;transition:all .3s}
    .month-filter input[type="month"]:focus{outline:none;border-color:#06b6d4;box-shadow:0 0 0 4px rgba(6,182,212,.1)}
    .month-filter .btn-filter{padding:10px 20px;border:none;border-radius:12px;background:linear-gradient(135deg,#06b6d4,#0891b2);color:#fff;font-weight:700;font-family:'Inter',sans-serif;cursor:pointer;transition:all .3s;font-size:.88rem}
    .month-filter .btn-filter:hover{transform:translateY(-2px);box-shadow:0 8px 25px rgba(6,182,212,.3)}

    .alert-box{padding:14px 18px;border-radius:14px;font-size:.88rem;margin-bottom:20px;display:flex;align-items:center;gap:10px;animation:slideIn .4s ease}
    .alert-success{background:#f0fdf4;color:#166534;border:1px solid #bbf7d0}
    .alert-error{background:#fef2f2;color:#991b1b;border:1px solid #fecaca}
    @keyframes slideIn{from{opacity:0;transform:translateX(-10px)}to{opacity:1;transform:translateX(0)}}

    .today-card{background:#fff;border-radius:20px;border:1px solid #f1f5f9;padding:28px 32px;display:flex;align-items:center;gap:24px;margin-bottom:24px;position:relative;overflow:hidden;transition:all .3s}
    .today-card:hover{box-shadow:0 8px 30px rgba(0,0,0,.06)}
    .today-card::before{content:'';position:absolute;top:0;left:0;right:0;height:4px;background:linear-gradient(90deg,#06b6d4,#22d3ee)}
    .today-icon{width:60px;height:60px;border-radius:18px;display:flex;align-items:center;justify-content:center;font-size:1.6rem;flex-shrink:0}
    .today-info{flex:1}
    .today-info h4{font-size:1.1rem;font-weight:700;color:#1e293b;margin:0 0 4px}
    .today-info p{font-size:.85rem;color:#64748b;margin:0}
    .today-times{display:flex;gap:20px;align-items:center}
    .time-block{text-align:center}
    .time-block .lbl{font-size:.7rem;color:#94a3b8;font-weight:600;text-transform:uppercase;letter-spacing:.5px}
    .time-block .val{font-size:1.2rem;font-weight:800;color:#1e293b}
    .clock-btn{padding:12px 28px;border:none;border-radius:14px;font-weight:700;font-family:'Inter',sans-serif;color:#fff;cursor:pointer;transition:all .3s;font-size:.9rem;display:flex;align-items:center;gap:8px}
    .clock-btn:hover{transform:translateY(-2px)}
    .btn-clockin{background:linear-gradient(135deg,#10b981,#059669);box-shadow:0 6px 20px rgba(16,185,129,.3)}
    .btn-clockin:hover{box-shadow:0 10px 30px rgba(16,185,129,.4)}
    .btn-clockout{background:linear-gradient(135deg,#ef4444,#dc2626);box-shadow:0 6px 20px rgba(239,68,68,.3)}
    .btn-clockout:hover{box-shadow:0 10px 30px rgba(239,68,68,.4)}
    .btn-done{background:#e2e8f0;color:#64748b;cursor:default}

    .stat-card{background:#fff;border-radius:16px;padding:22px;border:1px solid #f1f5f9;transition:all .3s cubic-bezier(.4,0,.2,1);position:relative;overflow:hidden;height:100%}
    .stat-card:hover{transform:translateY(-4px);box-shadow:0 12px 40px rgba(0,0,0,.08)}
    .stat-icon{width:48px;height:48px;border-radius:14px;display:flex;align-items:center;justify-content:center;font-size:1.2rem;margin-bottom:14px}
    .stat-val{font-size:1.8rem;font-weight:800;letter-spacing:-1px;line-height:1;margin-bottom:4px;color:#1e293b}
    .stat-lbl{font-size:.78rem;color:#64748b;font-weight:500;text-transform:uppercase;letter-spacing:.5px}
    .stat-bar{position:absolute;bottom:0;left:0;right:0;height:4px;border-radius:0 0 16px 16px}
    .icon-emerald{background:#ecfdf5;color:#10b981}.icon-rose{background:#fff1f2;color:#f43f5e}.icon-amber{background:#fffbeb;color:#f59e0b}.icon-sky{background:#ecfeff;color:#0ea5e9}
    .bar-emerald{background:linear-gradient(90deg,#10b981,#34d399)}.bar-rose{background:linear-gradient(90deg,#f43f5e,#fb7185)}.bar-amber{background:linear-gradient(90deg,#f59e0b,#fbbf24)}.bar-sky{background:linear-gradient(90deg,#0ea5e9,#38bdf8)}

    .table-card{background:#fff;border-radius:20px;border:1px solid #f1f5f9;overflow:hidden;margin-top:24px}
    .table-card:hover{box-shadow:0 8px 30px rgba(0,0,0,.06)}
    .table-header{padding:20px 24px;display:flex;justify-content:space-between;align-items:center;border-bottom:1px solid #f1f5f9}
    .table-header h5{font-size:1rem;font-weight:700;color:#1e293b;margin:0;display:flex;align-items:center;gap:8px}
    .table-header h5 .t-icon{width:32px;height:32px;border-radius:10px;display:flex;align-items:center;justify-content:center;font-size:.85rem;background:#ecfeff;color:#06b6d4}
    .att-table{width:100%;border-collapse:collapse}
    .att-table th{padding:12px 20px;text-align:left;font-size:.78rem;font-weight:700;color:#64748b;text-transform:uppercase;letter-spacing:.5px;background:#f8fafc;border-bottom:1px solid #f1f5f9}
    .att-table td{padding:14px 20px;font-size:.88rem;color:#334155;border-bottom:1px solid #f8fafc;transition:background .2s}
    .att-table tr:hover td{background:#fafafe}
    .att-table tr:last-child td{border-bottom:none}
    .status-badge{padding:4px 12px;border-radius:20px;font-size:.72rem;font-weight:700;text-transform:uppercase;letter-spacing:.5px}
    .badge-present{background:#dcfce7;color:#166534}.badge-absent{background:#fee2e2;color:#991b1b}.badge-half_day{background:#fef3c7;color:#92400e}.badge-leave{background:#dbeafe;color:#1e40af}
    .date-cell{font-weight:600}.day-cell{color:#94a3b8;font-size:.82rem}
    .empty-state{text-align:center;padding:48px 20px}
    .empty-state i{font-size:3rem;color:#e2e8f0}
    .empty-state p{color:#94a3b8;font-size:.9rem;margin-top:8px}

    .fade-up{opacity:0;transform:translateY(20px);animation:fadeUp .5s ease forwards}
    @keyframes fadeUp{to{opacity:1;transform:translateY(0)}}
    .fade-up:nth-child(1){animation-delay:.05s}.fade-up:nth-child(2){animation-delay:.1s}.fade-up:nth-child(3){animation-delay:.15s}.fade-up:nth-child(4){animation-delay:.2s}

    @media(max-width:768px){
        .page-header{flex-direction:column;align-items:flex-start}
        .today-card{flex-direction:column;text-align:center}
        .today-times{justify-content:center}
        .att-table th,.att-table td{padding:10px 12px;font-size:.8rem}
    }
</style>

<div class="att-page">
    @if(session('success'))
        <div class="alert-box alert-success"><i class="bi bi-check-circle-fill" style="font-size:1.2rem"></i>{{ session('success') }}</div>
    @endif
    @if(session('error'))
        <div class="alert-box alert-error"><i class="bi bi-exclamation-circle-fill" style="font-size:1.2rem"></i>{{ session('error') }}</div>
    @endif

    <div class="page-header fade-up">
        <h1><span class="h-icon"><i class="bi bi-calendar-check-fill"></i></span> My Attendance</h1>
        <form class="month-filter" method="GET" action="{{ route('employee.attendance.index') }}">
            <input type="month" name="month" value="{{ $month }}">
            <button type="submit" class="btn-filter"><i class="bi bi-funnel-fill me-1"></i>Filter</button>
        </form>
    </div>

    {{-- Today's Status --}}
    <div class="today-card fade-up">
        @if(!$todayAttendance)
            <div class="today-icon" style="background:#fef3c7;color:#f59e0b;"><i class="bi bi-clock"></i></div>
            <div class="today-info">
                <h4><span style="display:inline-block;width:10px;height:10px;border-radius:50%;background:#f59e0b;margin-right:8px;"></span>Not Clocked In</h4>
                <p>Today, {{ now()->format('l d M Y') }} — Start your workday!</p>
            </div>
            <form method="POST" action="{{ route('employee.attendance.clock-in') }}" class="gps-form">
                @csrf
                <input type="hidden" name="latitude" class="gps-lat">
                <input type="hidden" name="longitude" class="gps-lng">
                <button type="submit" class="clock-btn btn-clockin"><i class="bi bi-play-circle-fill"></i> Clock In</button>
            </form>
        @elseif(!$todayAttendance->clock_out)
            <div class="today-icon" style="background:#ecfdf5;color:#10b981;"><i class="bi bi-clock-fill"></i></div>
            <div class="today-info">
                <h4><span style="display:inline-block;width:10px;height:10px;border-radius:50%;background:#10b981;animation:pulse 1.5s infinite;margin-right:8px;"></span>Working</h4>
                <p>Today, {{ now()->format('l d M Y') }}</p>
            </div>
            <div class="today-times">
                <div class="time-block">
                    <div class="lbl">Clock In</div>
                    <div class="val" style="color:#10b981;">{{ \Carbon\Carbon::parse($todayAttendance->clock_in)->format('h:i A') }}</div>
                </div>
            </div>
            <form method="POST" action="{{ route('employee.attendance.clock-out') }}" class="gps-form">
                @csrf
                <input type="hidden" name="latitude" class="gps-lat">
                <input type="hidden" name="longitude" class="gps-lng">
                <button type="submit" class="clock-btn btn-clockout"><i class="bi bi-stop-circle-fill"></i> Clock Out</button>
            </form>
        @else
            <div class="today-icon" style="background:#dbeafe;color:#3b82f6;"><i class="bi bi-check-circle-fill"></i></div>
            <div class="today-info">
                <h4><span style="display:inline-block;width:10px;height:10px;border-radius:50%;background:#3b82f6;margin-right:8px;"></span>Day Complete</h4>
                <p>Today, {{ now()->format('l d M Y') }} — {{ $todayAttendance->working_hours }}h worked</p>
            </div>
            <div class="today-times">
                <div class="time-block">
                    <div class="lbl">Clock In</div>
                    <div class="val" style="color:#10b981;">{{ \Carbon\Carbon::parse($todayAttendance->clock_in)->format('h:i A') }}</div>
                </div>
                <div class="time-block">
                    <div class="lbl">Clock Out</div>
                    <div class="val" style="color:#ef4444;">{{ \Carbon\Carbon::parse($todayAttendance->clock_out)->format('h:i A') }}</div>
                </div>
            </div>
            <span class="clock-btn btn-done"><i class="bi bi-check-lg"></i> Done</span>
        @endif
    </div>
    <style>@keyframes pulse{0%,100%{opacity:1}50%{opacity:.4}}</style>

    {{-- Summary Stats --}}
    <div class="row g-3 mb-3">
        <div class="col-6 col-lg-3 fade-up">
            <div class="stat-card">
                <div class="stat-icon icon-emerald"><i class="bi bi-check-circle-fill"></i></div>
                <div class="stat-val">{{ $summary['present'] }}</div>
                <div class="stat-lbl">Present Days</div>
                <div class="stat-bar bar-emerald"></div>
            </div>
        </div>
        <div class="col-6 col-lg-3 fade-up">
            <div class="stat-card">
                <div class="stat-icon icon-rose"><i class="bi bi-x-circle-fill"></i></div>
                <div class="stat-val">{{ $summary['absent'] }}</div>
                <div class="stat-lbl">Absent Days</div>
                <div class="stat-bar bar-rose"></div>
            </div>
        </div>
        <div class="col-6 col-lg-3 fade-up">
            <div class="stat-card">
                <div class="stat-icon icon-amber"><i class="bi bi-slash-circle-fill"></i></div>
                <div class="stat-val">{{ $summary['half_day'] }}</div>
                <div class="stat-lbl">Half Days</div>
                <div class="stat-bar bar-amber"></div>
            </div>
        </div>
        <div class="col-6 col-lg-3 fade-up">
            <div class="stat-card">
                <div class="stat-icon icon-sky"><i class="bi bi-hourglass-split"></i></div>
                <div class="stat-val">{{ number_format($summary['total_hours'], 1) }}</div>
                <div class="stat-lbl">Total Hours</div>
                <div class="stat-bar bar-sky"></div>
            </div>
        </div>
    </div>

    {{-- Attendance Table --}}
    <div class="table-card fade-up">
        <div class="table-header">
            <h5><span class="t-icon"><i class="bi bi-table"></i></span> Attendance Records — {{ \Carbon\Carbon::parse($month)->format('F Y') }}</h5>
        </div>
        @if($attendances->count())
            <div style="overflow-x:auto;">
                <table class="att-table">
                    <thead>
                        <tr>
                            <th>Date</th>
                            <th>Day</th>
                            <th>Clock In</th>
                            <th>Clock Out</th>
                            <th>Hours</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($attendances as $att)
                        <tr>
                            <td class="date-cell">{{ $att->date->format('d M Y') }}</td>
                            <td class="day-cell">{{ $att->date->format('l') }}</td>
                            <td>{{ $att->clock_in ? \Carbon\Carbon::parse($att->clock_in)->format('h:i A') : '—' }}</td>
                            <td>{{ $att->clock_out ? \Carbon\Carbon::parse($att->clock_out)->format('h:i A') : '—' }}</td>
                            <td><strong>{{ $att->working_hours ? number_format($att->working_hours, 1).'h' : '—' }}</strong></td>
                            <td><span class="status-badge badge-{{ $att->status }}">{{ str_replace('_',' ',$att->status) }}</span></td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @else
            <div class="empty-state">
                <i class="bi bi-calendar-x"></i>
                <p>No attendance records found for {{ \Carbon\Carbon::parse($month)->format('F Y') }}</p>
            </div>
        @endif
    </div>
</div>

<script>
(function() {
    // ════════════════════════════════════════════════════
    // DEMO MODE: Hardcoded US Address (Times Square, New York, USA)
    // IP: 72.229.28.185 (New York ISP)
    // Lat: 40.7580, Lng: -73.9855
    // Address: 1560 Broadway, New York, NY 10036, USA
    // ════════════════════════════════════════════════════

    let userLat = 40.7580;    // Times Square, NYC
    let userLng = -73.9855;   // Times Square, NYC
    let gpsReady = true;

    // Set GPS values immediately
    document.querySelectorAll('.gps-lat').forEach(el => el.value = userLat);
    document.querySelectorAll('.gps-lng').forEach(el => el.value = userLng);

    document.querySelectorAll('.gps-form').forEach(function(form) {
        form.addEventListener('submit', function(e) {
            form.querySelector('.gps-lat').value = userLat;
            form.querySelector('.gps-lng').value = userLng;
        });
    });

    // ════════════════════════════════════════════════════
    // ORIGINAL CODE (Real GPS — uncomment for production)
    // ════════════════════════════════════════════════════
    /*
    let userLat = null, userLng = null, gpsReady = false;
    if (navigator.geolocation) {
        navigator.geolocation.getCurrentPosition(
            function(pos) {
                userLat = pos.coords.latitude;
                userLng = pos.coords.longitude;
                gpsReady = true;
                document.querySelectorAll('.gps-lat').forEach(el => el.value = userLat);
                document.querySelectorAll('.gps-lng').forEach(el => el.value = userLng);
            },
            function() {},
            { enableHighAccuracy: true, timeout: 10000 }
        );
    }
    document.querySelectorAll('.gps-form').forEach(function(form) {
        form.addEventListener('submit', function(e) {
            if (gpsReady) {
                form.querySelector('.gps-lat').value = userLat;
                form.querySelector('.gps-lng').value = userLng;
            } else if (navigator.geolocation) {
                e.preventDefault();
                navigator.geolocation.getCurrentPosition(
                    function(pos) {
                        form.querySelector('.gps-lat').value = pos.coords.latitude;
                        form.querySelector('.gps-lng').value = pos.coords.longitude;
                        form.submit();
                    },
                    function() { form.submit(); },
                    { enableHighAccuracy: true, timeout: 5000 }
                );
            }
        });
    });
    */
})();
</script>
@endsection
