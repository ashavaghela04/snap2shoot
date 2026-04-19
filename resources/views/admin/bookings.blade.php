@extends('admin.layout')
@section('title', 'Bookings | Snap2Shoot Admin')
@section('content')

<header>
    <div class="header-left">
        <div class="menu-toggle" id="menu-toggle"><i class="fas fa-bars"></i></div>
        <div class="page-title">
            <h2>Bookings Management</h2>
            <p style="color: var(--text-muted); font-size: 0.9rem;">Manage all scheduled shoots</p>
        </div>
    </div>
    <div class="user-profile">
        <img src="https://ui-avatars.com/api/?name=Admin+User&background=c9a24d&color=fff" class="user-img">
    </div>
</header>

@if (session('success'))
<div style="background:#d4edda;color:#155724;padding:12px 20px;border-radius:8px;margin-bottom:20px;border:1px solid #c3e6cb;">
    <i class="fas fa-check-circle"></i> {{ session('success') }}
</div>
@endif

<!-- Add Booking Form -->
<div class="card" style="margin-bottom:25px;">
    <div class="section-header"><h3>+ New Booking</h3></div>
    <form method="POST" action="{{ url('/admin/bookings') }}" style="display:grid;grid-template-columns:1fr 1fr 1fr;gap:15px;padding-top:15px;">
        @csrf
        <input type="text"   name="client_name"    placeholder="Client Name *"   required style="padding:10px;border:1px solid #ddd;border-radius:6px;">
        <input type="email"  name="client_email"   placeholder="Email *"          required style="padding:10px;border:1px solid #ddd;border-radius:6px;">
        <input type="text"   name="client_phone"   placeholder="Phone *"          required style="padding:10px;border:1px solid #ddd;border-radius:6px;">
        <select name="service_id" style="padding:10px;border:1px solid #ddd;border-radius:6px;">
            <option value="">Select Service</option>
            @foreach ($services as $s)
            <option value="{{ $s->id }}">{{ $s->name }}</option>
            @endforeach
        </select>
        <input type="date"   name="event_date"     style="padding:10px;border:1px solid #ddd;border-radius:6px;">
        <input type="text"   name="event_location" placeholder="Location"         style="padding:10px;border:1px solid #ddd;border-radius:6px;">
        <input type="number" name="amount"         placeholder="Amount (₹)"       style="padding:10px;border:1px solid #ddd;border-radius:6px;">
        <select name="status" style="padding:10px;border:1px solid #ddd;border-radius:6px;">
            <option value="pending">Pending</option>
            <option value="confirmed">Confirmed</option>
            <option value="completed">Completed</option>
            <option value="cancelled">Cancelled</option>
        </select>
        <button type="submit" style="background:var(--accent-color);color:#fff;border:none;border-radius:6px;padding:10px;cursor:pointer;font-weight:600;">Add Booking</button>
    </form>
</div>

<!-- Bookings Table -->
<div class="card">
    <div class="section-header">
        <h3>All Bookings</h3>
        <div style="display:flex;gap:10px;">
            @foreach (['all','pending','confirmed','completed','cancelled'] as $s)
            <a href="?status={{ $s }}" style="background:{{ request('status',$s==='all'?'all':'') === $s ? 'var(--accent-color)':'#f3ebe3' }};color:{{ request('status',$s==='all'?'all':'') === $s ? '#fff':'var(--text-muted)' }};padding:6px 14px;border-radius:20px;font-size:0.85rem;text-decoration:none;border:1px solid var(--border-color);">
                {{ ucfirst($s) }}
            </a>
            @endforeach
        </div>
    </div>
    <div class="table-responsive">
        <table>
            <thead>
                <tr><th>ID</th><th>Client</th><th>Service</th><th>Date</th><th>Location</th><th>Amount</th><th>Status</th><th>Action</th></tr>
            </thead>
            <tbody>
                @forelse ($bookings as $booking)
                <tr>
                    <td>#BK-{{ str_pad($booking->id, 4, '0', STR_PAD_LEFT) }}</td>
                    <td>
                        <strong>{{ $booking->client_name }}</strong><br>
                        <small style="color:var(--text-muted);">{{ $booking->client_phone }}</small>
                    </td>
                    <td>{{ $booking->service?->name ?? '—' }}</td>
                    <td>{{ $booking->event_date ? $booking->event_date->format('M d, Y') : '—' }}</td>
                    <td>{{ $booking->event_location ?? '—' }}</td>
                    <td>{{ $booking->amount ? '₹' . number_format($booking->amount) : '—' }}</td>
                    <td><span class="status-badge status-{{ $booking->status }}">{{ ucfirst($booking->status) }}</span></td>
                    <td>
                        <form method="POST" action="{{ url('/admin/bookings/' . $booking->id) }}" style="display:inline;">
                            @csrf @method('PUT')
                            <select name="status" onchange="this.form.submit()" style="border:1px solid #ddd;padding:4px;border-radius:4px;font-size:0.8rem;">
                                @foreach (['pending','confirmed','completed','cancelled'] as $st)
                                <option value="{{ $st }}" {{ $booking->status === $st ? 'selected' : '' }}>{{ ucfirst($st) }}</option>
                                @endforeach
                            </select>
                        </form>
                        <form method="POST" action="{{ url('/admin/bookings/' . $booking->id) }}" style="display:inline;" onsubmit="return confirm('Delete this booking?')">
                            @csrf @method('DELETE')
                            <button type="submit" class="action-btn" style="color:var(--danger);"><i class="fas fa-trash"></i></button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr><td colspan="8" style="text-align:center;padding:30px;color:var(--text-muted);">No bookings found.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div style="padding:15px 0;">{{ $bookings->links() }}</div>
</div>
@endsection
