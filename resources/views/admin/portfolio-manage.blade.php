@extends('admin.layout')
@section('title', 'Portfolio | Snap2Shoot Admin')
@section('content')

<header>
    <div class="header-left">
        <div class="menu-toggle" id="menu-toggle"><i class="fas fa-bars"></i></div>
        <div class="page-title">
            <h2>Portfolio Management</h2>
            <p style="color: var(--text-muted); font-size: 0.9rem;">Add or remove portfolio images</p>
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

@if ($errors->any())
<div style="background:#f8d7da;color:#721c24;padding:12px 20px;border-radius:8px;margin-bottom:20px;border:1px solid #f5c6cb;">
    <i class="fas fa-exclamation-circle"></i>
    <ul style="margin:6px 0 0 18px;padding:0;">
        @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
        @endforeach
    </ul>
</div>
@endif

<!-- Add Form -->
<div class="card" style="margin-bottom:25px;">
    <div class="section-header"><h3>+ Add Portfolio Item</h3></div>
    {{-- enctype required for file upload --}}
    <form method="POST" action="{{ url('/admin/portfolio-manage') }}" enctype="multipart/form-data"
          style="display:grid;grid-template-columns:1fr 1fr 1fr;gap:15px;padding-top:15px;">
        @csrf

        <input type="text" name="title" placeholder="Title *" required value="{{ old('title') }}"
               style="padding:10px;border:1px solid #ddd;border-radius:6px;">

        <input type="text" name="location" placeholder="Location" value="{{ old('location') }}"
               style="padding:10px;border:1px solid #ddd;border-radius:6px;">

        <select name="category" required style="padding:10px;border:1px solid #ddd;border-radius:6px;">
            <option value="">Select Category *</option>
            @foreach ($categories as $cat)
                <option value="{{ $cat }}" {{ old('category') == $cat ? 'selected' : '' }}>{{ ucfirst($cat) }}</option>
            @endforeach
        </select>

        {{-- Image file upload spanning 2 columns --}}
        <div style="grid-column:span 2;">
            <label style="display:block;font-size:0.85rem;margin-bottom:4px;color:var(--text-muted);">Image File * (JPEG / PNG / WebP, max 5 MB)</label>
            <input type="file" name="image" accept="image/jpeg,image/png,image/jpg,image/webp" required
                   style="padding:8px;border:1px solid #ddd;border-radius:6px;width:100%;box-sizing:border-box;background:#fafafa;">
        </div>

        <label style="display:flex;align-items:center;gap:8px;">
            <input type="checkbox" name="is_featured" value="1" {{ old('is_featured') ? 'checked' : '' }}> Featured on homepage
        </label>

        <input type="text" name="description" placeholder="Short description" value="{{ old('description') }}"
               style="padding:10px;border:1px solid #ddd;border-radius:6px;grid-column:span 2;">

        <button type="submit"
                style="background:var(--accent-color);color:#fff;border:none;border-radius:6px;padding:10px;cursor:pointer;font-weight:600;">
            Add Item
        </button>
    </form>
</div>

<!-- Portfolio Gallery Grid -->
<div class="card">
    <div class="section-header"><h3>All Portfolio Items ({{ $items->count() }})</h3></div>
    <div style="display:grid;grid-template-columns:repeat(auto-fill,minmax(220px,1fr));gap:20px;padding-top:15px;">
        @forelse ($items as $item)
        <div style="position:relative;border-radius:10px;overflow:hidden;box-shadow:0 2px 8px rgba(0,0,0,0.1);">
            {{-- Uses the getImageUrlAttribute() accessor on the model --}}
            <img src="{{ $item->image_url }}" alt="{{ $item->title }}"
                 style="width:100%;height:180px;object-fit:cover;">
            <div style="padding:10px;background:#fff;">
                <strong style="font-size:0.9rem;">{{ $item->title }}</strong><br>
                <small style="color:var(--text-muted);">{{ ucfirst($item->category) }} | {{ $item->location }}</small><br>
                @if ($item->is_featured)
                    <span style="background:#c9a24d;color:#fff;font-size:0.7rem;padding:2px 8px;border-radius:20px;">Featured</span>
                @endif

                {{-- Inline edit form --}}
                <details style="margin-top:8px;">
                    <summary style="cursor:pointer;font-size:0.8rem;color:var(--accent-color);font-weight:600;">Edit</summary>
                    <form method="POST" action="{{ url('/admin/portfolio-manage/' . $item->id) }}"
                          enctype="multipart/form-data" style="margin-top:8px;display:flex;flex-direction:column;gap:6px;">
                        @csrf @method('PUT')
                        <input type="text" name="title" value="{{ $item->title }}" required
                               style="padding:6px;border:1px solid #ddd;border-radius:4px;font-size:0.8rem;">
                        <input type="text" name="location" value="{{ $item->location }}" placeholder="Location"
                               style="padding:6px;border:1px solid #ddd;border-radius:4px;font-size:0.8rem;">
                        <select name="category" required style="padding:6px;border:1px solid #ddd;border-radius:4px;font-size:0.8rem;">
                            @foreach ($categories as $cat)
                                <option value="{{ $cat }}" {{ $item->category == $cat ? 'selected' : '' }}>{{ ucfirst($cat) }}</option>
                            @endforeach
                        </select>
                        <label style="font-size:0.75rem;color:var(--text-muted);">Replace Image (optional)</label>
                        <input type="file" name="image" accept="image/jpeg,image/png,image/jpg,image/webp"
                               style="font-size:0.75rem;">
                        <label style="display:flex;align-items:center;gap:6px;font-size:0.8rem;">
                            <input type="checkbox" name="is_featured" value="1" {{ $item->is_featured ? 'checked' : '' }}> Featured
                        </label>
                        <label style="display:flex;align-items:center;gap:6px;font-size:0.8rem;">
                            <input type="checkbox" name="is_active" value="1" {{ $item->is_active ? 'checked' : '' }}> Active
                        </label>
                        <button type="submit"
                                style="background:var(--accent-color);color:#fff;border:none;border-radius:4px;padding:5px;cursor:pointer;font-size:0.8rem;">
                            Save Changes
                        </button>
                    </form>
                </details>

                <div style="margin-top:8px;">
                    <form method="POST" action="{{ url('/admin/portfolio-manage/' . $item->id) }}"
                          onsubmit="return confirm('Delete this item?')">
                        @csrf @method('DELETE')
                        <button type="submit"
                                style="background:var(--danger);color:#fff;border:none;border-radius:4px;padding:4px 10px;cursor:pointer;font-size:0.8rem;width:100%;">
                            <i class="fas fa-trash"></i> Delete
                        </button>
                    </form>
                </div>
            </div>
        </div>
        @empty
        <p style="grid-column:span 4;text-align:center;padding:40px;color:var(--text-muted);">No portfolio items yet.</p>
        @endforelse
    </div>
</div>
@endsection