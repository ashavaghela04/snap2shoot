@extends('admin.layout')
@section('title', 'Reports | Snap2Shoot Admin')
@push('styles')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
@endpush
@section('content')

<header>
    <div class="header-left">
        <div class="menu-toggle" id="menu-toggle"><i class="fas fa-bars"></i></div>
        <div class="page-title">
            <h2>Reports & Analytics</h2>
            <p style="color: var(--text-muted); font-size: 0.9rem;">Business performance overview</p>
        </div>
    </div>
    <div class="user-profile">
        <img src="https://ui-avatars.com/api/?name=Admin+User&background=c9a24d&color=fff" alt="Admin" class="user-img">
    </div>
</header>

<!-- Summary Stats -->
<div class="stats-grid" style="margin-bottom:25px;">
    <div class="card stat-card">
        <div class="stat-info"><h3>₹{{ number_format($yearlyRevenue) }}</h3><p>Yearly Revenue</p></div>
        <div class="stat-icon icon-green"><i class="fas fa-rupee-sign"></i></div>
    </div>
    <div class="card stat-card">
        <div class="stat-info"><h3>{{ $totalBookings }}</h3><p>Total Bookings</p></div>
        <div class="stat-icon icon-blue"><i class="fas fa-calendar-check"></i></div>
    </div>
    <div class="card stat-card">
        <div class="stat-info"><h3>{{ $totalReviews }}</h3><p>Approved Reviews</p></div>
        <div class="stat-icon icon-green"><i class="fas fa-star"></i></div>
    </div>
    <div class="card stat-card">
        <div class="stat-info"><h3>{{ number_format($avgRating, 1) }}/5</h3><p>Average Rating</p></div>
        <div class="stat-icon icon-red"><i class="fas fa-chart-line"></i></div>
    </div>
</div>

<div class="dashboard-grid">
    <!-- Revenue Chart -->
    <div class="card">
        <div class="section-header"><h3>Monthly Revenue ({{ now()->year }})</h3></div>
        <canvas id="revenueChart" height="200"></canvas>
    </div>

    <!-- Booking Stats -->
    <div class="card">
        <div class="section-header"><h3>Booking Status</h3></div>
        <canvas id="statusChart" height="200"></canvas>
    </div>
</div>

<!-- Monthly Table -->
<div class="card" style="margin-top:25px;">
    <div class="section-header"><h3>Monthly Breakdown</h3></div>
    <div class="table-responsive">
        <table>
            <thead>
                <tr><th>Month</th><th>Bookings</th><th>Revenue</th></tr>
            </thead>
            <tbody>
                @foreach ($monthlyData as $row)
                <tr>
                    <td>{{ $row['month'] }}</td>
                    <td>{{ $row['bookings'] }}</td>
                    <td>₹{{ number_format($row['revenue']) }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

@endsection

@push('scripts')
<script>
new Chart(document.getElementById('revenueChart').getContext('2d'), {
    type: 'bar',
    data: {
        labels: @json(array_column($monthlyData, 'month')),
        datasets: [{
            label: 'Revenue (₹)',
            data: @json(array_column($monthlyData, 'revenue')),
            backgroundColor: 'rgba(201,162,77,0.7)',
            borderColor: '#c9a24d',
            borderWidth: 1,
        }]
    },
    options: { responsive: true, plugins: { legend: { display: false } }, scales: { y: { beginAtZero: true } } }
});
new Chart(document.getElementById('statusChart').getContext('2d'), {
    type: 'doughnut',
    data: {
        labels: ['Completed','Confirmed','Pending','Cancelled'],
        datasets: [{
            data: [{{ $completedBookings }}, {{ $totalBookings - $completedBookings - $pendingBookings }}, {{ $pendingBookings }}, 0],
            backgroundColor: ['#10b981','#c9a24d','#f59e0b','#ef4444'],
        }]
    },
    options: { responsive: true }
});
</script>
@endpush
