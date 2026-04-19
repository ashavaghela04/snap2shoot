@extends('admin.layout')
@section('title','Team Members | Admin')

@section('content')

<link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@500;600&family=DM+Sans:wght@300;400;500;600&display=swap" rel="stylesheet">

<style>
:root {
  --gold: #c9a24d;
  --gold-light: #e8c97a;
  --gold-dim: rgba(201,162,77,0.12);
  --dark: #1a1a2e;
  --surface: #ffffff;
  --surface-2: #f9f7f4;
  --border: #ede8df;
  --text: #2c2c3e;
  --muted: #8a8899;
  --red: #e74c3c;
  --blue: #3498db;
  --shadow: 0 4px 24px rgba(0,0,0,0.07);
  --shadow-hover: 0 8px 40px rgba(201,162,77,0.18);
}

* { box-sizing: border-box; }

.tm-wrapper {
  font-family: 'DM Sans', sans-serif;
  color: var(--text);
  padding: 0 4px;
}

/* PAGE HEADER */
.tm-header {
  display: flex;
  justify-content: space-between;
  align-items: flex-end;
  margin-bottom: 32px;
  padding-bottom: 24px;
  border-bottom: 1px solid var(--border);
}

.tm-header-left h2 {
  font-family: 'Playfair Display', serif;
  font-size: 2rem;
  font-weight: 600;
  margin: 0 0 4px;
  color: var(--dark);
  letter-spacing: -0.5px;
}

.tm-header-left p {
  color: var(--muted);
  margin: 0;
  font-size: 0.9rem;
  font-weight: 300;
}

.tm-add-btn {
  display: inline-flex;
  align-items: center;
  gap: 8px;
  background: var(--gold);
  color: #fff;
  border: none;
  padding: 11px 22px;
  border-radius: 10px;
  font-family: 'DM Sans', sans-serif;
  font-size: 0.9rem;
  font-weight: 500;
  cursor: pointer;
  transition: background 0.2s, transform 0.15s, box-shadow 0.2s;
  box-shadow: 0 2px 12px rgba(201,162,77,0.3);
}

.tm-add-btn:hover {
  background: var(--gold-light);
  transform: translateY(-1px);
  box-shadow: 0 6px 20px rgba(201,162,77,0.4);
}

.tm-add-btn i { font-size: 0.85rem; }

/* STATS BAR */
.tm-stats {
  display: flex;
  gap: 16px;
  margin-bottom: 28px;
}

.tm-stat {
  background: var(--surface-2);
  border: 1px solid var(--border);
  border-radius: 10px;
  padding: 14px 20px;
  min-width: 120px;
}

.tm-stat-num {
  font-size: 1.6rem;
  font-weight: 600;
  color: var(--gold);
  font-family: 'Playfair Display', serif;
  line-height: 1;
}

.tm-stat-label {
  font-size: 0.78rem;
  color: var(--muted);
  margin-top: 3px;
  text-transform: uppercase;
  letter-spacing: 0.5px;
}

/* TABLE CARD */
.tm-card {
  background: var(--surface);
  border: 1px solid var(--border);
  border-radius: 16px;
  overflow: hidden;
  box-shadow: var(--shadow);
}

.tm-table {
  width: 100%;
  border-collapse: collapse;
}

.tm-table thead tr {
  background: var(--surface-2);
  border-bottom: 2px solid var(--border);
}

.tm-table th {
  padding: 14px 18px;
  text-align: left;
  font-size: 0.72rem;
  font-weight: 600;
  text-transform: uppercase;
  letter-spacing: 1px;
  color: var(--muted);
}

.tm-table tbody tr {
  border-bottom: 1px solid var(--border);
  transition: background 0.15s;
}

.tm-table tbody tr:last-child { border-bottom: none; }

.tm-table tbody tr:hover { background: var(--gold-dim); }

.tm-table td {
  padding: 16px 18px;
  vertical-align: middle;
}

/* AVATAR */
.tm-avatar-wrap {
  position: relative;
  display: inline-block;
}

.tm-avatar {
  width: 48px;
  height: 48px;
  border-radius: 50%;
  object-fit: cover;
  border: 2px solid var(--gold-light);
  display: block;
}

/* NAME CELL */
.tm-name {
  font-weight: 600;
  font-size: 0.95rem;
  color: var(--dark);
}

.tm-email {
  font-size: 0.8rem;
  color: var(--muted);
  margin-top: 2px;
}

/* BADGE */
.tm-badge {
  display: inline-block;
  background: var(--gold-dim);
  color: var(--gold);
  border: 1px solid rgba(201,162,77,0.3);
  padding: 4px 12px;
  border-radius: 20px;
  font-size: 0.78rem;
  font-weight: 500;
}

/* PHONE */
.tm-phone {
  font-size: 0.88rem;
  color: var(--text);
}

/* EXPERIENCE */
.tm-exp {
  display: inline-flex;
  align-items: center;
  gap: 6px;
  font-size: 0.88rem;
  font-weight: 500;
  color: var(--dark);
}

.tm-exp-bar {
  width: 40px;
  height: 4px;
  background: var(--border);
  border-radius: 2px;
  overflow: hidden;
}

.tm-exp-fill {
  height: 100%;
  background: var(--gold);
  border-radius: 2px;
}

/* ACTION BUTTONS */
.tm-actions {
  display: flex;
  gap: 8px;
  align-items: center;
}

.btn-act {
  width: 34px;
  height: 34px;
  display: inline-flex;
  align-items: center;
  justify-content: center;
  border: none;
  border-radius: 8px;
  cursor: pointer;
  font-size: 0.8rem;
  transition: all 0.15s;
}

.btn-act-edit {
  background: rgba(52,152,219,0.12);
  color: var(--blue);
}

.btn-act-edit:hover {
  background: var(--blue);
  color: #fff;
  transform: scale(1.05);
}

.btn-act-del {
  background: rgba(231,76,60,0.1);
  color: var(--red);
}

.btn-act-del:hover {
  background: var(--red);
  color: #fff;
  transform: scale(1.05);
}

.inline { display: inline; }

/* EMPTY STATE */
.tm-empty {
  text-align: center;
  padding: 60px 20px;
  color: var(--muted);
}

.tm-empty i {
  font-size: 2.5rem;
  color: var(--border);
  margin-bottom: 12px;
  display: block;
}

/* MODAL OVERLAY */
.tm-modal {
  display: none;
  position: fixed;
  inset: 0;
  background: rgba(26,26,46,0.55);
  backdrop-filter: blur(4px);
  z-index: 1000;
  align-items: center;
  justify-content: center;
}

.tm-modal.active { display: flex; }

.tm-modal-box {
  background: var(--surface);
  width: 480px;
  max-width: 95vw;
  border-radius: 20px;
  overflow: hidden;
  box-shadow: 0 24px 60px rgba(0,0,0,0.2);
  animation: slideUp 0.25s ease;
  max-height: 90vh;
  overflow-y: auto;
}

@keyframes slideUp {
  from { opacity: 0; transform: translateY(20px); }
  to   { opacity: 1; transform: translateY(0); }
}

.tm-modal-head {
  background: linear-gradient(135deg, var(--dark) 0%, #2d2d4e 100%);
  padding: 22px 28px;
  display: flex;
  align-items: center;
  justify-content: space-between;
}

.tm-modal-head h3 {
  font-family: 'Playfair Display', serif;
  font-size: 1.25rem;
  color: #fff;
  margin: 0;
}

.tm-modal-close {
  background: rgba(255,255,255,0.1);
  border: none;
  color: #fff;
  width: 30px;
  height: 30px;
  border-radius: 50%;
  cursor: pointer;
  font-size: 0.9rem;
  display: flex;
  align-items: center;
  justify-content: center;
  transition: background 0.15s;
}

.tm-modal-close:hover { background: rgba(255,255,255,0.2); }

.tm-modal-body {
  padding: 28px;
}

.tm-form-grid {
  display: grid;
  grid-template-columns: 1fr 1fr;
  gap: 16px;
}

.tm-form-group {
  display: flex;
  flex-direction: column;
  gap: 6px;
}

.tm-form-group.full { grid-column: 1 / -1; }

.tm-form-group label {
  font-size: 0.78rem;
  font-weight: 600;
  color: var(--muted);
  text-transform: uppercase;
  letter-spacing: 0.5px;
}

.tm-form-group input,
.tm-form-group textarea {
  border: 1.5px solid var(--border);
  border-radius: 8px;
  padding: 10px 13px;
  font-family: 'DM Sans', sans-serif;
  font-size: 0.9rem;
  color: var(--text);
  outline: none;
  transition: border-color 0.15s, box-shadow 0.15s;
  background: var(--surface-2);
  width: 100%;
}

.tm-form-group input:focus,
.tm-form-group textarea:focus {
  border-color: var(--gold);
  box-shadow: 0 0 0 3px rgba(201,162,77,0.12);
  background: #fff;
}

.tm-form-group textarea { resize: vertical; min-height: 80px; }

/* File Upload */
.tm-file-upload {
  border: 2px dashed var(--border);
  border-radius: 10px;
  padding: 20px;
  text-align: center;
  cursor: pointer;
  transition: border-color 0.2s, background 0.2s;
  position: relative;
  background: var(--surface-2);
}

.tm-file-upload:hover {
  border-color: var(--gold);
  background: var(--gold-dim);
}

.tm-file-upload input[type="file"] {
  position: absolute;
  inset: 0;
  opacity: 0;
  cursor: pointer;
  width: 100%;
  height: 100%;
  border: none;
  padding: 0;
}

.tm-file-icon {
  font-size: 1.4rem;
  color: var(--gold);
  margin-bottom: 6px;
}

.tm-file-text {
  font-size: 0.82rem;
  color: var(--muted);
}

.tm-preview {
  width: 60px;
  height: 60px;
  border-radius: 50%;
  object-fit: cover;
  border: 2px solid var(--gold);
  margin: 10px auto 0;
  display: none;
}

/* Modal Footer */
.tm-modal-footer {
  padding: 20px 28px;
  border-top: 1px solid var(--border);
  display: flex;
  gap: 10px;
  justify-content: flex-end;
  background: var(--surface-2);
}

.btn-save {
  background: var(--gold);
  color: #fff;
  border: none;
  padding: 10px 24px;
  border-radius: 8px;
  font-family: 'DM Sans', sans-serif;
  font-size: 0.9rem;
  font-weight: 500;
  cursor: pointer;
  transition: background 0.2s, transform 0.15s;
}

.btn-save:hover {
  background: var(--gold-light);
  transform: translateY(-1px);
}

.btn-cancel {
  background: transparent;
  color: var(--muted);
  border: 1.5px solid var(--border);
  padding: 10px 20px;
  border-radius: 8px;
  font-family: 'DM Sans', sans-serif;
  font-size: 0.9rem;
  cursor: pointer;
  transition: all 0.15s;
}

.btn-cancel:hover {
  border-color: var(--muted);
  color: var(--text);
}

/* Responsive */
@media (max-width: 640px) {
  .tm-header { flex-direction: column; gap: 16px; align-items: flex-start; }
  .tm-form-grid { grid-template-columns: 1fr; }
  .tm-stats { flex-wrap: wrap; }
}
</style>

<div class="tm-wrapper">

  <!-- HEADER -->
  <div class="tm-header">
    <div class="tm-header-left">
      <h2>Team Members</h2>
      <p>Manage photographers &amp; staff</p>
    </div>
    <button class="tm-add-btn" onclick="openModal()">
      <i class="fas fa-plus"></i> Add Member
    </button>
  </div>

  <!-- STATS -->
  <div class="tm-stats">
    <div class="tm-stat">
      <div class="tm-stat-num">{{ $team->count() }}</div>
      <div class="tm-stat-label">Total Members</div>
    </div>
    <div class="tm-stat">
      <div class="tm-stat-num">{{ $team->where('experience','>=',5)->count() }}</div>
      <div class="tm-stat-label">Senior Staff</div>
    </div>
  </div>

  <!-- TABLE -->
  <div class="tm-card">
    <div style="overflow-x:auto;">
      <table class="tm-table">
        <thead>
          <tr>
            <th>Photo</th>
            <th>Member</th>
            <th>Designation</th>
            <th>Contact</th>
            <th>Experience</th>
            <th>Actions</th>
          </tr>
        </thead>
        <tbody>
          @forelse($team as $member)
          <tr>
            <td>
              <div class="tm-avatar-wrap">
                <img src="{{ $member->image_url ? asset('storage/'.$member->image_url) : asset('images/default-user.jpg') }}"
                     class="tm-avatar" alt="{{ $member->name }}">
              </div>
            </td>

            <td>
              <div class="tm-name">{{ $member->name }}</div>
              <div class="tm-email">{{ $member->email }}</div>
            </td>

            <td>
              <span class="tm-badge">{{ $member->designation }}</span>
            </td>

            <td>
              <div class="tm-phone">
                <i class="fas fa-phone" style="font-size:0.7rem;color:var(--muted);margin-right:5px;"></i>
                {{ $member->phone }}
              </div>
            </td>

            <td>
              <div class="tm-exp">
                <div class="tm-exp-bar">
                  <div class="tm-exp-fill" style="width:{{ min(($member->experience/20)*100, 100) }}%"></div>
                </div>
                {{ $member->experience }} yrs
              </div>
            </td>

            <td>
              <div class="tm-actions">
                <button class="btn-act btn-act-edit" title="Edit"
                  onclick="editMember(
                    '{{ $member->id }}',
                    '{{ addslashes($member->name) }}',
                    '{{ addslashes($member->designation) }}',
                    '{{ $member->email }}',
                    '{{ $member->phone }}',
                    '{{ $member->experience }}',
                    '{{ addslashes($member->bio) }}'
                  )">
                  <i class="fas fa-pencil-alt"></i>
                </button>

                <form method="POST" action="{{ route('admin.team.delete',$member->id) }}" class="inline"
                  onsubmit="return confirm('Remove this member?')">
                  @csrf
                  @method('DELETE')
                  <button class="btn-act btn-act-del" type="submit" title="Delete">
                    <i class="fas fa-trash-alt"></i>
                  </button>
                </form>
              </div>
            </td>
          </tr>
          @empty
          <tr>
            <td colspan="6">
              <div class="tm-empty">
                <i class="fas fa-users"></i>
                <p>No team members found.<br><small>Click "Add Member" to get started.</small></p>
              </div>
            </td>
          </tr>
          @endforelse
        </tbody>
      </table>
    </div>
  </div>

</div>

<!-- MODAL -->
<div class="tm-modal" id="teamModal">
  <div class="tm-modal-box">

    <div class="tm-modal-head">
      <h3 id="modalTitle">Add Team Member</h3>
      <button class="tm-modal-close" type="button" onclick="closeModal()">
        <i class="fas fa-times"></i>
      </button>
    </div>

    <form method="POST" action="{{ route('admin.team.store') }}" enctype="multipart/form-data">
      @csrf
      <input type="hidden" name="id" id="memberId">

      <div class="tm-modal-body">
        <div class="tm-form-grid">

          <div class="tm-form-group">
            <label>Full Name *</label>
            <input type="text" name="name" id="name" placeholder="e.g. Jane Doe" required>
          </div>

          <div class="tm-form-group">
            <label>Designation</label>
            <input type="text" name="designation" id="designation" placeholder="e.g. Photographer">
          </div>

          <div class="tm-form-group">
            <label>Email</label>
            <input type="email" name="email" id="email" placeholder="email@example.com">
          </div>

          <div class="tm-form-group">
            <label>Phone</label>
            <input type="text" name="phone" id="phone" placeholder="+91 00000 00000">
          </div>

          <div class="tm-form-group">
            <label>Experience (Years)</label>
            <input type="number" name="experience" id="experience" placeholder="0" min="0" max="50">
          </div>

          <div class="tm-form-group">
            <label>Photo</label>
            <div class="tm-file-upload">
              <input type="file" name="photo" accept="image/*" onchange="previewImage(event)">
              <div class="tm-file-icon"><i class="fas fa-cloud-upload-alt"></i></div>
              <div class="tm-file-text">Click to upload photo</div>
              <img id="preview" class="tm-preview" alt="Preview">
            </div>
          </div>

          <div class="tm-form-group full">
            <label>Bio</label>
            <textarea name="bio" id="bio" placeholder="Short bio about this team member..."></textarea>
          </div>

        </div>
      </div>

      <div class="tm-modal-footer">
        <button type="button" class="btn-cancel" onclick="closeModal()">Cancel</button>
        <button type="submit" class="btn-save"><i class="fas fa-save" style="margin-right:6px;"></i>Save Member</button>
      </div>
    </form>

  </div>
</div>

<script>
function openModal() {
  document.getElementById('teamModal').classList.add('active');
  document.body.style.overflow = 'hidden';
}

function closeModal() {
  document.getElementById('teamModal').classList.remove('active');
  document.body.style.overflow = '';
}

// Close on backdrop click
document.getElementById('teamModal').addEventListener('click', function(e) {
  if (e.target === this) closeModal();
});

function editMember(id, name, designation, email, phone, experience, bio) {
  openModal();
  document.getElementById('modalTitle').innerText = 'Edit Member';
  document.getElementById('memberId').value = id;
  document.getElementById('name').value = name;
  document.getElementById('designation').value = designation;
  document.getElementById('email').value = email;
  document.getElementById('phone').value = phone;
  document.getElementById('experience').value = experience;
  document.getElementById('bio').value = bio;
}

function previewImage(event) {
  const reader = new FileReader();
  reader.onload = function () {
    const img = document.getElementById('preview');
    img.src = reader.result;
    img.style.display = 'block';
  };
  reader.readAsDataURL(event.target.files[0]);
}
</script>

@endsection