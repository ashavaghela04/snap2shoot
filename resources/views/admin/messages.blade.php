@extends('admin.layout')
@section('title', 'Messages | Snap2Shoot Admin')
@section('content')

<header>
    <div class="header-left">
        <div class="menu-toggle" id="menu-toggle"><i class="fas fa-bars"></i></div>
        <div class="page-title">
            <h2>Inbox</h2>
            <p style="color: var(--text-muted); font-size: 0.9rem;">View enquiries from potential clients ({{ $unreadCount }} unread)</p>
        </div>
    </div>
    <div class="user-profile">
        <img src="https://ui-avatars.com/api/?name=Admin+User&background=c9a24d&color=fff" class="user-img" alt="Admin">
    </div>
</header>

@if (session('success'))
<div style="background:#d4edda;color:#155724;padding:12px 20px;border-radius:8px;margin-bottom:20px;border:1px solid #c3e6cb;">
    <i class="fas fa-check-circle"></i> {{ session('success') }}
</div>
@endif

<div class="card">
    <div class="section-header">
        <h3>Recent Enquiries</h3>
        @if ($unreadCount > 0)
        <form method="POST" action="{{ url('/admin/messages/mark-all-read') }}">
            @csrf
            <button type="submit" class="btn-sm btn-outline">Mark All Read</button>
        </form>
        @endif
    </div>

    <div class="message-list">
        @forelse ($messages as $msg)
        <div class="message-item {{ !$msg->is_read ? 'unread' : '' }}">
            <div class="msg-header">
                <span class="sender-name">
                    {{ !$msg->is_read ? '● ' : '' }}{{ $msg->name }}
                    <small style="color:var(--text-muted);font-weight:400;"> — {{ $msg->email }} | {{ $msg->phone }}</small>
                </span>
                <span class="msg-date">{{ $msg->created_at->diffForHumans() }}</span>
            </div>
            @if ($msg->service_interest)
            <span class="msg-service">Inquiry for: {{ ucfirst($msg->service_interest) }}</span>
            @endif
            @if ($msg->wedding_date)
            <span class="msg-service" style="margin-left:10px;">Wedding Date: {{ \Carbon\Carbon::parse($msg->wedding_date)->format('M d, Y') }}</span>
            @endif
            <p class="msg-preview">{{ $msg->message }}</p>
            <div class="msg-actions">
                <a href="mailto:{{ $msg->email }}" class="btn-sm btn-accent"><i class="fas fa-reply"></i> Reply</a>
                @if (!$msg->is_read)
                <form method="POST" action="{{ url('/admin/messages/' . $msg->id . '/read') }}" style="display:inline;">
                    @csrf
                    <button type="submit" class="btn-sm">Mark Read</button>
                </form>
                @endif
                <form method="POST" action="{{ url('/admin/messages/' . $msg->id) }}" style="display:inline;" onsubmit="return confirm('Delete this message?')">
                    @csrf @method('DELETE')
                    <button type="submit" class="btn-sm btn-danger-outline"><i class="fas fa-trash"></i> Delete</button>
                </form>
            </div>
        </div>
        @empty
        <p style="text-align:center;padding:40px;color:var(--text-muted);">No messages yet.</p>
        @endforelse
    </div>
    <div style="padding:15px 0;">{{ $messages->links() }}</div>
</div>
@endsection
