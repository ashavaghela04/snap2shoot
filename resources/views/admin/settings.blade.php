@extends('admin.layout')
@section('title', 'Settings | Snap2Shoot Admin')
@section('content')

<header>
    <div class="header-left">
        <div class="menu-toggle" id="menu-toggle"><i class="fas fa-bars"></i></div>
        <div class="page-title">
            <h2>Site Settings</h2>
            <p style="color: var(--text-muted); font-size: 0.9rem;">Manage studio information and site content</p>
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

<form method="POST" action="{{ url('/admin/settings') }}">
    @csrf

    <!-- Studio Info -->
    <div class="card" style="margin-bottom:25px;">
        <div class="section-header"><h3>Studio Information</h3></div>
        <div style="display:grid;grid-template-columns:1fr 1fr;gap:20px;padding-top:15px;">
            @foreach ([['studio_name','Studio Name'],['tagline','Tagline'],['phone_primary','Primary Phone'],['phone_secondary','Secondary Phone'],['email_primary','Primary Email'],['email_bookings','Bookings Email'],['whatsapp_number','WhatsApp Number (no +)'],['working_hours','Working Hours']] as [$key,$label])
            <div>
                <label style="display:block;margin-bottom:6px;font-size:0.9rem;color:var(--text-muted);">{{ $label }}</label>
                <input type="text" name="{{ $key }}" value="{{ $settings[$key] }}" style="width:100%;padding:10px;border:1px solid #ddd;border-radius:6px;">
            </div>
            @endforeach
            <div style="grid-column:span 2;">
                <label style="display:block;margin-bottom:6px;font-size:0.9rem;color:var(--text-muted);">Studio Address</label>
                <input type="text" name="address" value="{{ $settings['address'] }}" style="width:100%;padding:10px;border:1px solid #ddd;border-radius:6px;">
            </div>
        </div>
    </div>

    <!-- Social Links -->
    <div class="card" style="margin-bottom:25px;">
        <div class="section-header"><h3>Social Media Links</h3></div>
        <div style="display:grid;grid-template-columns:1fr 1fr;gap:20px;padding-top:15px;">
            @foreach ([['instagram_url','Instagram URL'],['facebook_url','Facebook URL'],['pinterest_url','Pinterest URL'],['youtube_url','YouTube URL']] as [$key,$label])
            <div>
                <label style="display:block;margin-bottom:6px;font-size:0.9rem;color:var(--text-muted);">{{ $label }}</label>
                <input type="text" name="{{ $key }}" value="{{ $settings[$key] }}" style="width:100%;padding:10px;border:1px solid #ddd;border-radius:6px;">
            </div>
            @endforeach
        </div>
    </div>

    <!-- Stats -->
    <div class="card" style="margin-bottom:25px;">
        <div class="section-header"><h3>Homepage Stats</h3></div>
        <div style="display:grid;grid-template-columns:1fr 1fr 1fr;gap:20px;padding-top:15px;">
            @foreach ([['years_experience','Years of Experience'],['weddings_count','Weddings Count'],['clients_count','Happy Clients Count']] as [$key,$label])
            <div>
                <label style="display:block;margin-bottom:6px;font-size:0.9rem;color:var(--text-muted);">{{ $label }}</label>
                <input type="text" name="{{ $key }}" value="{{ $settings[$key] }}" style="width:100%;padding:10px;border:1px solid #ddd;border-radius:6px;">
            </div>
            @endforeach
        </div>
    </div>

    <!-- Hero Section -->
    <div class="card" style="margin-bottom:25px;">
        <div class="section-header"><h3>Hero Section Content</h3></div>
        <div style="display:grid;gap:15px;padding-top:15px;">
            @foreach ([['hero_subtitle','Hero Subtitle'],['hero_title','Hero Title']] as [$key,$label])
            <div>
                <label style="display:block;margin-bottom:6px;font-size:0.9rem;color:var(--text-muted);">{{ $label }}</label>
                <input type="text" name="{{ $key }}" value="{{ $settings[$key] }}" style="width:100%;padding:10px;border:1px solid #ddd;border-radius:6px;">
            </div>
            @endforeach
            <div>
                <label style="display:block;margin-bottom:6px;font-size:0.9rem;color:var(--text-muted);">Hero Description</label>
                <textarea name="hero_description" rows="2" style="width:100%;padding:10px;border:1px solid #ddd;border-radius:6px;">{{ $settings['hero_description'] }}</textarea>
            </div>
        </div>
    </div>

    <!-- Quote Section -->
    <div class="card" style="margin-bottom:25px;">
        <div class="section-header"><h3>Quote Section</h3></div>
        <div style="display:grid;gap:15px;padding-top:15px;">
            <div>
                <label style="display:block;margin-bottom:6px;font-size:0.9rem;color:var(--text-muted);">Quote Text</label>
                <textarea name="quote_text" rows="3" style="width:100%;padding:10px;border:1px solid #ddd;border-radius:6px;">{{ $settings['quote_text'] }}</textarea>
            </div>
            <div>
                <label style="display:block;margin-bottom:6px;font-size:0.9rem;color:var(--text-muted);">Quote Author</label>
                <input type="text" name="quote_author" value="{{ $settings['quote_author'] }}" style="width:100%;padding:10px;border:1px solid #ddd;border-radius:6px;">
            </div>
            <div>
                <label style="display:block;margin-bottom:6px;font-size:0.9rem;color:var(--text-muted);">About Story</label>
                <textarea name="about_story" rows="4" style="width:100%;padding:10px;border:1px solid #ddd;border-radius:6px;">{{ $settings['about_story'] }}</textarea>
            </div>
        </div>
    </div>

    <button type="submit" style="background:var(--accent-color);color:#fff;border:none;border-radius:8px;padding:14px 35px;cursor:pointer;font-size:1rem;font-weight:600;"><i class="fas fa-save"></i> Save All Settings</button>
</form>
@endsection
