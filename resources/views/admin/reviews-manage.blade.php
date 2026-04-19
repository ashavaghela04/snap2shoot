@extends('admin.layout')
@section('title', 'Reviews | Snap2Shoot Admin')
@section('content')

<header>
    <div class="header-left">
        <div class="menu-toggle" id="menu-toggle"><i class="fas fa-bars"></i></div>
        <div class="page-title">
            <h2>Manage Reviews</h2>
            <p style="color: var(--text-muted); font-size: 0.9rem;">Approve or reject client testimonials</p>
        </div>
    </div>
    <div class="user-profile">
        <img src="https://ui-avatars.com/api/?name=Admin+User&background=c9a24d&color=fff" alt="Admin" class="user-img">
    </div>
</header>

@if (session('success'))
<div style="background:#d4edda;color:#155724;padding:12px 20px;border-radius:8px;margin-bottom:20px;border:1px solid #c3e6cb;">
    <i class="fas fa-check-circle"></i> {{ session('success') }}
</div>
@endif

<div class="card">
    <div class="section-header">
        <h3>Client Reviews</h3>
        <div style="display:flex;gap:8px;">
            @foreach (['all','pending','approved','rejected'] as $s)
            <a href="?status={{ $s }}" style="background:{{ request('status','all') === $s ? 'var(--accent-color)':'#f3ebe3' }};color:{{ request('status','all') === $s ? '#fff':'var(--text-muted)' }};padding:6px 14px;border-radius:20px;font-size:0.85rem;text-decoration:none;border:1px solid var(--border-color);">
                {{ ucfirst($s) }}
            </a>
            @endforeach
        </div>
    </div>
    <div class="table-responsive">
        <table>
            <thead>
                <tr><th>Client</th><th>Rating</th><th>Review</th><th>Type</th><th>Date</th><th>Status</th><th>Action</th></tr>
            </thead>
            <tbody>
                @forelse ($reviews as $review)
                <tr>
                    <td><strong>{{ $review->client_name }}</strong></td>
                    <td><span style="color:var(--gold-accent);"><i class="fas fa-star"></i> {{ $review->rating }}/5</span></td>
                    <td>{{ Str::limit($review->review_text, 70) }}</td>
                    <td>{{ ucfirst($review->event_type) }}</td>
                    <td>{{ $review->created_at->format('M d, Y') }}</td>
                    <td><span class="status-badge status-{{ $review->status === 'approved' ? 'confirmed' : ($review->status === 'pending' ? 'pending' : 'cancelled') }}">{{ ucfirst($review->status) }}</span></td>
                    <td>
                        @if ($review->status !== 'approved')
                        <form method="POST" action="{{ url('/admin/reviews-manage/' . $review->id . '/approve') }}" style="display:inline;">
                            @csrf
                            <button type="submit" class="action-btn" style="color:var(--success);" title="Approve"><i class="fas fa-check"></i></button>
                        </form>
                        @endif
                        @if ($review->status !== 'rejected')
                        <form method="POST" action="{{ url('/admin/reviews-manage/' . $review->id . '/reject') }}" style="display:inline;">
                            @csrf
                            <button type="submit" class="action-btn" style="color:orange;" title="Reject"><i class="fas fa-ban"></i></button>
                        </form>
                        @endif
                        <form method="POST" action="{{ url('/admin/reviews-manage/' . $review->id) }}" style="display:inline;" onsubmit="return confirm('Delete this review?')">
                            @csrf @method('DELETE')
                            <button type="submit" class="action-btn" style="color:var(--danger);" title="Delete"><i class="fas fa-trash"></i></button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr><td colspan="7" style="text-align:center;padding:30px;color:var(--text-muted);">No reviews found.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div style="padding:15px 0;">{{ $reviews->links() }}</div>
</div>
@endsection
