@extends('layouts.app')

@section('content')

    {{-- ── Page Header ── --}}
    <section class="page-header">
        <div class="container">
            <h1 class="page-title">Client Reviews</h1>
            <p class="page-subtitle">Hear from the wonderful couples who entrusted us with their special day</p>
        </div>
    </section>

    {{-- ── Overall Rating ── --}}
    <section class="section rating-section">
        <div class="container">
            <div class="rating-summary">
                <div class="rating-number">
                    <h2>{{ number_format($avgRating, 1) }}</h2>
                    <div class="stars">
                        @for ($i = 1; $i <= 5; $i++)
                            @if ($i <= floor($avgRating))
                                <i class="fas fa-star"></i>
                            @elseif ($i - $avgRating < 1)
                                <i class="fas fa-star-half-alt"></i>
                            @else
                                <i class="far fa-star"></i>
                            @endif
                        @endfor
                    </div>
                    <p>Based on {{ $totalApproved }} reviews</p>
                </div>
                <div class="rating-bars">
                    @foreach ($ratingCounts as $star => $count)
                    <div class="rating-bar">
                        <span>{{ $star }} stars</span>
                        <div class="bar-container">
                            <div class="bar" style="width: {{ $totalApproved > 0 ? round(($count / $totalApproved) * 100) : 0 }}%;"></div>
                        </div>
                        <span>{{ $count }}</span>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </section>

    {{-- ── Reviews Grid ── --}}
    <section class="section testimonials-grid">
        <div class="container">
            <div class="reviews-container">
                @forelse ($reviews as $review)
                <div class="testimonial-card">
                    <div class="stars">
                        @for ($i = 1; $i <= $review->rating; $i++)
                            <i class="fas fa-star"></i>
                        @endfor
                        @for ($i = $review->rating + 1; $i <= 5; $i++)
                            <i class="far fa-star"></i>
                        @endfor
                    </div>
                    <p class="testimonial-text">"{{ $review->review_text }}"</p>
                    <div class="client-info">
                        @if ($review->client_image_url)
                            <img src="{{ asset($review->client_image_url) }}"
                                 alt="{{ $review->client_name }}"
                                 style="width:50px;height:50px;border-radius:50%;object-fit:cover;">
                        @else
                            <div class="img-placeholder client-img"
                                 style="width:50px;height:50px;border-radius:50%;display:flex;align-items:center;justify-content:center;">
                                <i class="fas fa-user" style="color:#aaa;"></i>
                            </div>
                        @endif
                        <div>
                            <h4>{{ $review->client_name }}</h4>
                            <p>{{ $review->created_at->format('M Y') }}</p>
                        </div>
                    </div>
                </div>
                @empty
                    <p style="text-align:center;color:#666;grid-column:1/-1;">
                        No reviews yet. Be the first to share your experience!
                    </p>
                @endforelse
            </div>

            <div class="text-center" style="margin-top:40px;">
                {{ $reviews->links() }}
            </div>
        </div>
    </section>

    {{-- ══════════════════════════════════════════
         REVIEW SUBMISSION FORM
    ══════════════════════════════════════════ --}}
    <section class="section" id="write-review" style="background:#f9f6f1;">
        <div class="container">

            <div style="text-align:center;margin-bottom:40px;">
                <h2 class="section-title">Share Your Experience</h2>
                <p class="section-subtitle">Your kind words help other couples choose with confidence</p>
            </div>

            <div style="max-width:640px;margin:0 auto;background:#fff;border-radius:12px;
                        padding:44px 48px;box-shadow:0 4px 32px rgba(0,0,0,.08);">

                {{-- Success --}}
                @if(session('success'))
                <div style="background:#f0faf5;border:1px solid #a8d5bc;color:#2e7d5b;padding:14px 18px;
                            border-radius:8px;margin-bottom:28px;display:flex;align-items:center;gap:10px;font-size:.9rem;">
                    <i class="fas fa-check-circle"></i> {{ session('success') }}
                </div>
                @endif

                {{-- Error banner --}}
                @if($errors->any())
                <div style="background:#fdf3f2;border:1px solid #e8b4ae;color:#c0392b;padding:14px 18px;
                            border-radius:8px;margin-bottom:28px;display:flex;align-items:center;gap:10px;font-size:.9rem;">
                    <i class="fas fa-exclamation-circle"></i> Please fix the errors below and try again.
                </div>
                @endif

                {{-- enctype required for file upload --}}
                <form action="{{ route('reviews.store') }}" method="POST"
                      enctype="multipart/form-data" novalidate>
                    @csrf

                    {{-- ── Star Rating ── --}}
                    <div style="margin-bottom:26px;">
                        <label style="display:block;font-size:.78rem;font-weight:600;letter-spacing:.1em;
                                      text-transform:uppercase;color:#555;margin-bottom:12px;">
                            Your Rating <span style="color:#c9a96e;">*</span>
                        </label>

                        <div class="star-rating-input"
                             style="display:flex;align-items:center;gap:4px;direction:rtl;width:fit-content;">
                            @for($s = 5; $s >= 1; $s--)
                                <input type="radio" id="star{{ $s }}" name="rating" value="{{ $s }}"
                                       style="display:none;"
                                       {{ old('rating') == $s ? 'checked' : '' }}>
                                <label for="star{{ $s }}"
                                       style="font-size:2.2rem;color:#ddd;cursor:pointer;line-height:1;padding:2px;
                                              transition:color .15s,transform .15s;"
                                       onmouseover="highlightStars({{ $s }})"
                                       onmouseout="resetStars()"
                                       onclick="selectStar({{ $s }})">&#9733;</label>
                            @endfor
                        </div>

                        <span id="star-hint" style="display:inline-block;font-size:.82rem;color:#999;margin-top:6px;">
                            {{ old('rating') ? '' : 'Click to rate' }}
                        </span>

                        @error('rating')
                        <div style="color:#c0392b;font-size:.8rem;margin-top:6px;">
                            <i class="fas fa-exclamation-circle"></i> {{ $message }}
                        </div>
                        @enderror
                    </div>

                    {{-- ── Name ── --}}
                    <div style="margin-bottom:20px;">
                        <label for="client_name"
                               style="display:block;font-size:.78rem;font-weight:600;letter-spacing:.1em;
                                      text-transform:uppercase;color:#555;margin-bottom:8px;">
                            Your Name <span style="color:#c9a96e;">*</span>
                        </label>
                        <input type="text"
                               id="client_name"
                               name="client_name"
                               value="{{ old('client_name') }}"
                               placeholder="e.g. Priya & Rohan Sharma"
                               style="width:100%;box-sizing:border-box;padding:12px 16px;
                                      border:1.5px solid {{ $errors->has('client_name') ? '#c0392b' : '#e0d8cc' }};
                                      border-radius:8px;font-size:.95rem;color:#333;background:#faf7f2;
                                      outline:none;transition:border-color .2s,background .2s;"
                               onfocus="this.style.borderColor='#c9a96e';this.style.background='#fff';"
                               onblur="this.style.borderColor='{{ $errors->has('client_name') ? '#c0392b' : '#e0d8cc' }}';this.style.background='#faf7f2';">
                        @error('client_name')
                        <div style="color:#c0392b;font-size:.8rem;margin-top:5px;">
                            <i class="fas fa-exclamation-circle"></i> {{ $message }}
                        </div>
                        @enderror
                    </div>

                    {{-- ── Email ── --}}
                    <div style="margin-bottom:20px;">
                        <label for="client_email"
                               style="display:block;font-size:.78rem;font-weight:600;letter-spacing:.1em;
                                      text-transform:uppercase;color:#555;margin-bottom:8px;">
                            Email Address <span style="color:#c9a96e;">*</span>
                        </label>
                        <input type="email"
                               id="client_email"
                               name="client_email"
                               value="{{ old('client_email') }}"
                               placeholder="your@email.com"
                               style="width:100%;box-sizing:border-box;padding:12px 16px;
                                      border:1.5px solid {{ $errors->has('client_email') ? '#c0392b' : '#e0d8cc' }};
                                      border-radius:8px;font-size:.95rem;color:#333;background:#faf7f2;
                                      outline:none;transition:border-color .2s,background .2s;"
                               onfocus="this.style.borderColor='#c9a96e';this.style.background='#fff';"
                               onblur="this.style.borderColor='{{ $errors->has('client_email') ? '#c0392b' : '#e0d8cc' }}';this.style.background='#faf7f2';">
                        <span style="font-size:.75rem;color:#aaa;margin-top:4px;display:block;">
                            <i class="fas fa-lock"></i> Never displayed publicly
                        </span>
                        @error('client_email')
                        <div style="color:#c0392b;font-size:.8rem;margin-top:5px;">
                            <i class="fas fa-exclamation-circle"></i> {{ $message }}
                        </div>
                        @enderror
                    </div>

                    {{-- ── Review Text ── --}}
                    <div style="margin-bottom:20px;">
                        <label for="review_text"
                               style="display:block;font-size:.78rem;font-weight:600;letter-spacing:.1em;
                                      text-transform:uppercase;color:#555;margin-bottom:8px;">
                            Your Review <span style="color:#c9a96e;">*</span>
                        </label>
                        <textarea id="review_text"
                                  name="review_text"
                                  rows="5"
                                  placeholder="Tell us about your experience — the moments we captured, how we made you feel, and what made your day unforgettable…"
                                  style="width:100%;box-sizing:border-box;padding:12px 16px;
                                         border:1.5px solid {{ $errors->has('review_text') ? '#c0392b' : '#e0d8cc' }};
                                         border-radius:8px;font-size:.95rem;color:#333;background:#faf7f2;
                                         outline:none;resize:vertical;line-height:1.65;
                                         transition:border-color .2s,background .2s;"
                                  onfocus="this.style.borderColor='#c9a96e';this.style.background='#fff';"
                                  onblur="this.style.borderColor='{{ $errors->has('review_text') ? '#c0392b' : '#e0d8cc' }}';this.style.background='#faf7f2';">{{ old('review_text') }}</textarea>
                        @error('review_text')
                        <div style="color:#c0392b;font-size:.8rem;margin-top:5px;">
                            <i class="fas fa-exclamation-circle"></i> {{ $message }}
                        </div>
                        @enderror
                    </div>

                    {{-- ── Profile Photo Upload ── --}}
                    <div style="margin-bottom:30px;">
                        <label style="display:block;font-size:.78rem;font-weight:600;letter-spacing:.1em;
                                      text-transform:uppercase;color:#555;margin-bottom:8px;">
                            Your Photo <span style="font-weight:400;color:#aaa;text-transform:none;letter-spacing:0;">(Optional)</span>
                        </label>

                        {{-- Drop zone --}}
                        <div id="upload-zone"
                             onclick="document.getElementById('client_image').click()"
                             style="border:2px dashed {{ $errors->has('client_image') ? '#c0392b' : '#e0d8cc' }};
                                    border-radius:10px;padding:28px 20px;text-align:center;
                                    cursor:pointer;background:#faf7f2;transition:border-color .2s,background .2s;
                                    position:relative;">

                            {{-- Default state --}}
                            <div id="upload-placeholder">
                                <div style="width:56px;height:56px;border-radius:50%;background:#f0e9dc;
                                            display:flex;align-items:center;justify-content:center;
                                            margin:0 auto 12px;">
                                    <i class="fas fa-camera" style="font-size:1.4rem;color:#c9a96e;"></i>
                                </div>
                                <p style="margin:0 0 4px;font-size:.9rem;color:#555;font-weight:500;">
                                    Click to upload your photo
                                </p>
                                <p style="margin:0;font-size:.78rem;color:#aaa;">
                                    JPG, PNG or WEBP &bull; Max 2MB
                                </p>
                            </div>

                            {{-- Preview state (hidden by default) --}}
                            <div id="upload-preview" style="display:none;">
                                <img id="preview-img"
                                     src=""
                                     alt="Preview"
                                     style="width:72px;height:72px;border-radius:50%;object-fit:cover;
                                            border:3px solid #c9a96e;margin-bottom:10px;">
                                <p id="preview-name" style="margin:0 0 6px;font-size:.85rem;color:#555;font-weight:500;"></p>
                                <button type="button"
                                        onclick="removeImage(event)"
                                        style="background:none;border:1px solid #e0d8cc;border-radius:6px;
                                               padding:4px 12px;font-size:.78rem;color:#888;cursor:pointer;">
                                    <i class="fas fa-times"></i> Remove
                                </button>
                            </div>
                        </div>

                        {{-- Actual file input (hidden) --}}
                        <input type="file"
                               id="client_image"
                               name="client_image"
                               accept="image/jpeg,image/png,image/jpg,image/webp"
                               style="display:none;"
                               onchange="previewImage(this)">

                        @error('client_image')
                        <div style="color:#c0392b;font-size:.8rem;margin-top:6px;">
                            <i class="fas fa-exclamation-circle"></i> {{ $message }}
                        </div>
                        @enderror
                    </div>

                    {{-- ── Submit ── --}}
                    <div style="display:flex;align-items:center;justify-content:space-between;gap:16px;flex-wrap:wrap;">
                        <p style="font-size:.8rem;color:#aaa;margin:0;">
                            <i class="fas fa-shield-alt" style="color:#c9a96e;"></i>
                            Reviews are moderated before publishing.
                        </p>
                        <button type="submit" class="btn btn-primary"
                                style="display:inline-flex;align-items:center;gap:8px;">
                            <i class="fas fa-paper-plane"></i> Submit Review
                        </button>
                    </div>

                </form>
            </div>

        </div>
    </section>

    {{-- ── CTA ── --}}
    <section class="cta-section">
        <div class="container">
            <div class="cta-content">
                <h2 class="cta-title">Ready to Create Your Own Story?</h2>
                <p class="cta-description">Join hundreds of happy couples who trusted us with their special day.</p>
                <a href="{{ url('/contact') }}" class="btn btn-primary">Book a Consultation</a>
            </div>
        </div>
    </section>

@endsection

<script>
(function () {

    /* ── Star Rating ── */
    const hints  = { 1: 'Poor', 2: 'Fair', 3: 'Good', 4: 'Very Good', 5: 'Excellent!' };
    const labels = Array.from(document.querySelectorAll('.star-rating-input label'));

    function labelValue(lbl) { return 5 - labels.indexOf(lbl); }

    let selected = {{ old('rating', 0) }};

    function paint(upTo) {
        labels.forEach(function (lbl) {
            const v = labelValue(lbl);
            lbl.style.color     = v <= upTo ? '#c9a96e' : '#ddd';
            lbl.style.transform = v <= upTo ? 'scale(1.12)' : 'scale(1)';
        });
    }

    window.highlightStars = function (val) {
        paint(val);
        document.getElementById('star-hint').textContent = hints[val] || '';
    };
    window.resetStars = function () {
        paint(selected);
        document.getElementById('star-hint').textContent = selected ? hints[selected] : 'Click to rate';
    };
    window.selectStar = function (val) {
        selected = val;
        document.getElementById('star' + val).checked = true;
        paint(val);
        document.getElementById('star-hint').textContent = hints[val];
    };

    if (selected) { paint(selected); }

    /* ── Image Upload Preview ── */
    window.previewImage = function (input) {
        const zone        = document.getElementById('upload-zone');
        const placeholder = document.getElementById('upload-placeholder');
        const preview     = document.getElementById('upload-preview');
        const previewImg  = document.getElementById('preview-img');
        const previewName = document.getElementById('preview-name');

        if (input.files && input.files[0]) {
            const file = input.files[0];

            // 2 MB client-side guard
            if (file.size > 2 * 1024 * 1024) {
                alert('Image must be smaller than 2MB. Please choose a smaller file.');
                input.value = '';
                return;
            }

            const reader = new FileReader();
            reader.onload = function (e) {
                previewImg.src  = e.target.result;
                previewName.textContent = file.name;
                placeholder.style.display = 'none';
                preview.style.display     = 'block';
                zone.style.borderColor    = '#c9a96e';
                zone.style.background     = '#fffdf8';
            };
            reader.readAsDataURL(file);
        }
    };

    window.removeImage = function (e) {
        e.stopPropagation();
        const input       = document.getElementById('client_image');
        const zone        = document.getElementById('upload-zone');
        const placeholder = document.getElementById('upload-placeholder');
        const preview     = document.getElementById('upload-preview');

        input.value = '';
        preview.style.display     = 'none';
        placeholder.style.display = 'block';
        zone.style.borderColor    = '#e0d8cc';
        zone.style.background     = '#faf7f2';
    };

    // Hover effect on drop zone
    var zone = document.getElementById('upload-zone');
    zone.addEventListener('mouseenter', function () {
        this.style.borderColor = '#c9a96e';
        this.style.background  = '#fffdf8';
    });
    zone.addEventListener('mouseleave', function () {
        // Only reset if no image selected
        if (!document.getElementById('preview-img').src || document.getElementById('upload-preview').style.display === 'none') {
            this.style.borderColor = '{{ $errors->has('client_image') ? '#c0392b' : '#e0d8cc' }}';
            this.style.background  = '#faf7f2';
        }
    });

    // Drag & drop support
    zone.addEventListener('dragover', function (e) {
        e.preventDefault();
        this.style.borderColor = '#c9a96e';
        this.style.background  = '#fffdf8';
    });
    zone.addEventListener('dragleave', function () {
        if (document.getElementById('upload-preview').style.display === 'none') {
            this.style.borderColor = '#e0d8cc';
            this.style.background  = '#faf7f2';
        }
    });
    zone.addEventListener('drop', function (e) {
        e.preventDefault();
        const input = document.getElementById('client_image');
        const dt    = e.dataTransfer;
        if (dt.files && dt.files[0]) {
            input.files = dt.files;
            previewImage(input);
        }
    });

    /* ── Auto-scroll on error ── */
    @if($errors->any())
    setTimeout(function () {
        document.getElementById('write-review').scrollIntoView({ behavior: 'smooth', block: 'start' });
    }, 100);
    @endif

})();
</script>
