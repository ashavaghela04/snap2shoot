@extends('admin.layout')

@section('title', 'Dashboard | Snap2Shoot Admin')

@push('styles')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
@endpush

@section('content')

<header>
    <div class="header-left">
        <div class="menu-toggle" id="menu-toggle"><i class="fas fa-bars"></i></div>
        <div class="page-title">
            <h2>Dashboard Overview</h2>
            <p style="color: var(--text-muted); font-size: 0.9rem;">Welcome back, Admin</p>
        </div>
    </div>
    <div class="user-profile">
        <img src="https://ui-avatars.com/api/?name=Admin+User&background=c9a24d&color=fff" alt="Admin" class="user-img">
    </div>
</header>

<!-- Stats Grid -->
<div class="stats-grid">
    <div class="card stat-card">
        <div class="stat-info">
            <h3 class="counter" data-target="{{ $totalBookings }}">0</h3>
            <p>Total Bookings</p>
        </div>
        <div class="stat-icon icon-green"><i class="fas fa-camera"></i></div>
    </div>
    <div class="card stat-card">
        <div class="stat-info">
            <h3 class="counter" data-target="{{ $totalClients }}">0</h3>
            <p>Total Clients</p>
        </div>
        <div class="stat-icon icon-blue"><i class="fas fa-users"></i></div>
    </div>
    <div class="card stat-card">
        <div class="stat-info">
            <h3>₹<span class="counter" data-target="{{ $monthlyRevenue }}">0</span></h3>
            <p>Monthly Revenue</p>
        </div>
        <div class="stat-icon icon-green"><i class="fas fa-rupee-sign"></i></div>
    </div>
    <div class="card stat-card">
        <div class="stat-info">
            <h3 class="counter" data-target="{{ $upcomingCount }}">0</h3>
            <p>Upcoming Shoots</p>
        </div>
        <div class="stat-icon icon-red"><i class="fas fa-clock"></i></div>
    </div>
</div>

@if ($pendingReviews > 0)
<div style="background:#fff3cd;color:#856404;padding:12px 20px;border-radius:8px;margin-bottom:20px;border:1px solid #ffc107;">
    <i class="fas fa-star"></i> You have <strong>{{ $pendingReviews }}</strong> pending review(s) awaiting approval.
    <a href="{{ url('/admin/reviews-manage') }}" style="color:#856404;font-weight:600;margin-left:10px;">Review Now →</a>
</div>
@endif

<!-- Dashboard Grid -->
<div class="dashboard-grid">
    <!-- Revenue Chart -->
    <div class="card">
        <div class="section-header">
            <h3>Revenue Analytics ({{ now()->year }})</h3>
        </div>
        <canvas id="revenueChart" height="200"></canvas>
    </div>

    <!-- Upcoming Shoots -->
    <div class="card">
        <div class="section-header">
            <h3>Upcoming Shoots</h3>
        </div>
        <ul class="upcoming-list" style="margin-top: 10px;">
            @forelse ($upcomingBookings as $booking)
            <li style="display: flex; gap: 15px; margin-bottom: 20px; align-items: center;">
                <div style="width:40px;height:40px;background:rgba(16,185,129,0.2);color:var(--accent-color);border-radius:10px;display:flex;align-items:center;justify-content:center;font-weight:bold;">
                    {{ $booking->event_date ? $booking->event_date->format('d') : '—' }}
                </div>
                <div>
                    <h4 style="font-size: 0.95rem;">{{ $booking->client_name }}</h4>
                    <p style="color: var(--text-muted); font-size: 0.8rem;">
                        {{ $booking->service?->name ?? 'N/A' }} • {{ $booking->event_location }}
                    </p>
                </div>
            </li>
            @empty
            <li style="color:var(--text-muted);padding:20px 0;">No upcoming shoots scheduled.</li>
            @endforelse
        </ul>
    </div>
</div>

<!-- Recent Messages -->
@if ($recentMessages->count() > 0)
<div class="card" style="margin-top:20px;">
    <div class="section-header">
        <h3>New Enquiries</h3>
        <a href="{{ url('/admin/messages') }}" class="btn-sm">View All</a>
    </div>
    <div class="table-responsive">
        <table>
            <thead>
                <tr><th>Name</th><th>Email</th><th>Service</th><th>Date</th></tr>
            </thead>
            <tbody>
                @foreach ($recentMessages as $msg)
                <tr>
                    <td>{{ $msg->name }}</td>
                    <td>{{ $msg->email }}</td>
                    <td>{{ $msg->service_interest ?? '—' }}</td>
                    <td>{{ $msg->created_at->format('M d, Y') }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endif

@endsection

@push('scripts')
<script>
const ctx = document.getElementById('revenueChart').getContext('2d');
new Chart(ctx, {
    type: 'line',
    data: {
        labels: ['Jan','Feb','Mar','Apr','May','Jun','Jul','Aug','Sep','Oct','Nov','Dec'],
        datasets: [{
            label: 'Revenue (₹)',
            data: @json($revenueData),
            borderColor: '#c9a24d',
            backgroundColor: 'rgba(201,162,77,0.1)',
            tension: 0.4,
            fill: true,
        }]
    },
    options: {
        responsive: true,
        plugins: { legend: { display: false } },
        scales: {
            y: { beginAtZero: true, ticks: { callback: v => '₹' + v.toLocaleString() } }
        }
    }
});
</script>
@endpush
