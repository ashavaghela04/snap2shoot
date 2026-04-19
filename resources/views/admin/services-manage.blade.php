@extends('admin.layout')
@section('title', 'Services | Snap2Shoot Admin')
@section('content')

<header>
    <div class="header-left">
        <div class="menu-toggle" id="menu-toggle"><i class="fas fa-bars"></i></div>
        <div class="page-title">
            <h2>Manage Services</h2>
            <p style="color: var(--text-muted); font-size: 0.9rem;">Add, edit, or remove photography packages</p>
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

<!-- Add Service Form -->
<div class="card" style="margin-bottom:25px;">
    <div class="section-header"><h3>+ Add New Service</h3></div>
    <form method="POST" action="{{ url('/admin/services-manage') }}" style="padding-top:15px;">
        @csrf
        <div style="display:grid;grid-template-columns:1fr 1fr;gap:15px;">
            <div>
                <label style="display:block;margin-bottom:5px;font-size:0.9rem;color:var(--text-muted);">Service Name *</label>
                <input type="text" name="name" required style="width:100%;padding:10px;border:1px solid #ddd;border-radius:6px;">
            </div>
            <div>
                <label style="display:block;margin-bottom:5px;font-size:0.9rem;color:var(--text-muted);">Price Label *</label>
                <input type="text" name="price_label" placeholder="Starting from ₹25,000" required style="width:100%;padding:10px;border:1px solid #ddd;border-radius:6px;">
            </div>
            <div>
                <label style="display:block;margin-bottom:5px;font-size:0.9rem;color:var(--text-muted);">Font Awesome Icon *</label>
                <input type="text" name="icon" placeholder="fas fa-camera" required style="width:100%;padding:10px;border:1px solid #ddd;border-radius:6px;">
            </div>
            <div>
                <label style="display:block;margin-bottom:5px;font-size:0.9rem;color:var(--text-muted);">Image URL</label>
                <input type="url" name="image_url" placeholder="https://..." style="width:100%;padding:10px;border:1px solid #ddd;border-radius:6px;">
            </div>
            <div style="grid-column:span 2;">
                <label style="display:block;margin-bottom:5px;font-size:0.9rem;color:var(--text-muted);">Description *</label>
                <textarea name="description" rows="3" required style="width:100%;padding:10px;border:1px solid #ddd;border-radius:6px;"></textarea>
            </div>
            <div style="grid-column:span 2;">
                <label style="display:block;margin-bottom:5px;font-size:0.9rem;color:var(--text-muted);">Features (one per line)</label>
                <textarea name="features" rows="5" placeholder="Full day coverage (12+ hours)&#10;Two professional photographers&#10;..." style="width:100%;padding:10px;border:1px solid #ddd;border-radius:6px;"></textarea>
            </div>
        </div>
        <button type="submit" style="margin-top:15px;background:var(--accent-color);color:#fff;border:none;border-radius:6px;padding:12px 25px;cursor:pointer;font-weight:600;">Add Service</button>
    </form>
</div>

<!-- Services Table -->
<div class="card">
    <div class="section-header"><h3>Current Services</h3></div>
    <div class="table-responsive">
        <table>
            <thead>
                <tr><th>Icon</th><th>Service Name</th><th>Price</th><th>Status</th><th>Action</th></tr>
            </thead>
            <tbody>
                @forelse ($services as $service)
                <tr>
                    <td><i class="{{ $service->icon }}" style="font-size:1.5rem;color:var(--accent-color);"></i></td>
                    <td>
                        <strong>{{ $service->name }}</strong><br>
                        <small style="color:var(--text-muted);">{{ Str::limit($service->description, 60) }}</small>
                    </td>
                    <td>{{ $service->price_label }}</td>
                    <td><span class="status-badge {{ $service->is_active ? 'status-confirmed' : 'status-cancelled' }}">{{ $service->is_active ? 'Active' : 'Inactive' }}</span></td>
                    <td>
                        <button class="action-btn" onclick="editService({{ $service->id }}, {{ json_encode($service) }})"><i class="fas fa-edit"></i></button>
                        <form method="POST" action="{{ url('/admin/services-manage/' . $service->id) }}" style="display:inline;" onsubmit="return confirm('Delete this service?')">
                            @csrf @method('DELETE')
                            <button type="submit" class="action-btn" style="color:var(--danger);"><i class="fas fa-trash"></i></button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr><td colspan="5" style="text-align:center;padding:30px;color:var(--text-muted);">No services yet.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<!-- Edit Modal -->
<div id="editModal" style="display:none;position:fixed;inset:0;background:rgba(0,0,0,0.5);z-index:9999;align-items:center;justify-content:center;">
    <div style="background:#fff;border-radius:12px;padding:30px;width:600px;max-height:80vh;overflow-y:auto;">
        <h3 style="margin-bottom:20px;">Edit Service</h3>
        <form id="editForm" method="POST">
            @csrf @method('PUT')
            <div style="display:grid;grid-template-columns:1fr 1fr;gap:15px;">
                <div>
                    <label style="display:block;margin-bottom:5px;font-size:0.9rem;">Name *</label>
                    <input type="text" name="name" id="edit_name" required style="width:100%;padding:10px;border:1px solid #ddd;border-radius:6px;">
                </div>
                <div>
                    <label style="display:block;margin-bottom:5px;font-size:0.9rem;">Price Label *</label>
                    <input type="text" name="price_label" id="edit_price_label" required style="width:100%;padding:10px;border:1px solid #ddd;border-radius:6px;">
                </div>
                <div>
                    <label style="display:block;margin-bottom:5px;font-size:0.9rem;">Icon *</label>
                    <input type="text" name="icon" id="edit_icon" required style="width:100%;padding:10px;border:1px solid #ddd;border-radius:6px;">
                </div>
                <div>
                    <label style="display:block;margin-bottom:5px;font-size:0.9rem;">Image URL</label>
                    <input type="url" name="image_url" id="edit_image_url" style="width:100%;padding:10px;border:1px solid #ddd;border-radius:6px;">
                </div>
                <div style="grid-column:span 2;">
                    <label style="display:block;margin-bottom:5px;font-size:0.9rem;">Description *</label>
                    <textarea name="description" id="edit_description" rows="3" required style="width:100%;padding:10px;border:1px solid #ddd;border-radius:6px;"></textarea>
                </div>
                <div style="grid-column:span 2;">
                    <label style="display:block;margin-bottom:5px;font-size:0.9rem;">Features (one per line)</label>
                    <textarea name="features" id="edit_features" rows="5" style="width:100%;padding:10px;border:1px solid #ddd;border-radius:6px;"></textarea>
                </div>
                <div>
                    <label><input type="checkbox" name="is_active" id="edit_is_active" value="1"> Active</label>
                </div>
            </div>
            <div style="display:flex;gap:10px;margin-top:20px;">
                <button type="submit"  style="background:var(--accent-color);color:#fff;border:none;border-radius:6px;padding:10px 20px;cursor:pointer;font-weight:600;">Save Changes</button>
                <button type="button" onclick="document.getElementById('editModal').style.display='none'" style="background:#f3ebe3;color:var(--text-color);border:1px solid #ddd;border-radius:6px;padding:10px 20px;cursor:pointer;">Cancel</button>
            </div>
        </form>
    </div>
</div>
@endsection

@push('scripts')
<script>
function editService(id, service) {
    document.getElementById('editForm').action = 'http://localhost/snap2shoot_final/public/admin/services-manage/' + id;
    document.getElementById('edit_name').value = service.name;
    document.getElementById('edit_price_label').value = service.price_label;
    document.getElementById('edit_icon').value = service.icon;
    document.getElementById('edit_image_url').value = service.image_url || '';
    document.getElementById('edit_description').value = service.description;
    document.getElementById('edit_features').value = service.features ? service.features.join('\n') : '';
    document.getElementById('edit_is_active').checked = service.is_active;
    document.getElementById('editModal').style.display = 'flex';
}
</script>
@endpush
