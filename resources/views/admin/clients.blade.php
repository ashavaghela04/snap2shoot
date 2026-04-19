@extends('admin.layout')
@section('title', 'Clients | Snap2Shoot Admin')
@section('content')

<header>
    <div class="header-left">
        <div class="menu-toggle" id="menu-toggle"><i class="fas fa-bars"></i></div>
        <div class="page-title">
            <h2>Clients</h2>
            <p style="color: var(--text-muted); font-size: 0.9rem;">All clients derived from bookings</p>
        </div>
    </div>
    <div class="user-profile">
        <img src="https://ui-avatars.com/api/?name=Admin+User&background=c9a24d&color=fff" alt="Admin" class="user-img">
    </div>
</header>

<div class="card">
    <div class="section-header"><h3>Client Directory</h3></div>
    <div class="table-responsive">
        <table>
            <thead>
                <tr><th>Name</th><th>Email</th><th>Phone</th><th>Bookings</th><th>Total Spent</th><th>Last Booking</th></tr>
            </thead>
            <tbody>
                @forelse ($clients as $client)
                <tr>
                    <td>
                        <img src="https://ui-avatars.com/api/?name={{ urlencode($client->client_name) }}&background=c9a24d&color=fff&size=32" style="width:32px;height:32px;border-radius:50%;margin-right:8px;vertical-align:middle;">
                        {{ $client->client_name }}
                    </td>
                    <td>{{ $client->client_email }}</td>
                    <td>{{ $client->client_phone }}</td>
                    <td><span class="status-badge status-confirmed">{{ $client->booking_count }}</span></td>
                    <td>₹{{ number_format($client->total_spent ?? 0) }}</td>
                    <td>{{ \Carbon\Carbon::parse($client->last_booking)->format('M d, Y') }}</td>
                </tr>
                @empty
                <tr><td colspan="6" style="text-align:center;padding:30px;color:var(--text-muted);">No clients yet.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div style="padding:15px 0;">{{ $clients->links() }}</div>
</div>
@endsection
