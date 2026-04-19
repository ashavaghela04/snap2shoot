@extends('layouts.app')

@section('content')
    <!-- Hero Section -->
    <section class="hero">
        <div class="video-slider">
            <div class="video-slide active">
                <video autoplay muted loop playsinline class="bg-video">
                    <source src="{{ asset('videos/hero4.mp4') }}" type="video/mp4">
                </video>
                <div class="video-overlay"></div>
            </div>
            <div class="video-slide">
                <video autoplay muted loop playsinline class="bg-video">
                    <source src="{{ asset('videos/hero.mp4') }}" type="video/mp4">
                </video>
                <div class="video-overlay"></div>
            </div>
        </div>
        <div class="hero-content">
            <h4 class="hero-subtitle">{{ $settings['hero_subtitle'] }}</h4>
            <h1 class="hero-title">{{ $settings['hero_title'] }}</h1>
            <p class="hero-description">{{ $settings['hero_description'] }}</p>
            <div class="hero-buttons">
                <a href="{{ url('/portfolio') }}" class="btn btn-primary">View Portfolio</a>
                <a href="{{ url('/contact') }}" class="btn btn-secondary">Book Now</a>
            </div>
        </div>
        <div class="video-controls">
            <button class="video-control active" data-slide="0"></button>
            <button class="video-control" data-slide="1"></button>
        </div>
    </section>

    <!-- About Preview -->
    <section class="section about-preview">
        <div class="container">
            <div class="section-header">
                <h4 class="section-subtitle">Our Story</h4>
                <h2 class="section-title">Ahmedabad's Premier Wedding Photography Studio</h2>
                <p class="section-description">{{ $settings['about_story'] }}</p>
            </div>
            <div class="about-content">
                <div class="about-image">
                    <div class="img-placeholder photographer-img"><img src="{{ asset('images/photographer.jpg') }}" alt="Photographer" ></div>
                    <div class="experience-badge">
                        <span class="exp-years">{{ $settings['years_experience'] }}</span>
                        <span class="exp-text">Years Experience</span>
                    </div>
                </div>
                <div class="about-text">
                    <h3>Meet Rajveer, Your Storyteller</h3>
                    <p>Based in the heart of Ahmedabad, Snap2Shoot was born from a passion for capturing the raw, emotional, and magical moments of Indian weddings.</p>
                    <div class="about-stats">
                        <div class="stat">
                            <span class="stat-number" data-count="{{ $settings['weddings_count'] }}">0</span>
                            <span class="stat-label">Weddings</span>
                        </div>
                        <div class="stat">
                            <span class="stat-number" data-count="{{ $settings['clients_count'] }}">0</span>
                            <span class="stat-label">Happy Clients</span>
                        </div>
                        <div class="stat">
                            <span class="stat-number" data-count="{{ ltrim($settings['years_experience'], '+') }}">0</span>
                            <span class="stat-label">Years</span>
                        </div>
                    </div>
                    <a href="{{ url('/about') }}" class="btn btn-outline">Read Our Full Story</a>
                </div>
            </div>
        </div>
    </section>

    <!-- Services Preview -->
    <section class="section services-preview">
        <div class="container">
            <div class="section-header">
                <h4 class="section-subtitle">Our Services</h4>
                <h2 class="section-title">Comprehensive Wedding Photography Packages</h2>
                <p class="section-description">Tailored packages to capture every moment of your celebration with elegance and precision.</p>
            </div>
            <div class="services-grid">
                @foreach ($services as $service)
                <div class="service-card">
                    <div class="service-icon">
                        <i class="{{ $service->icon }}"></i>
                    </div>
                    <h3 class="service-title">{{ $service->name }}</h3>
                    <p class="service-description">{{ Str::limit($service->description, 100) }}</p>
                    <a href="{{ url('/services#' . $service->slug) }}" class="service-link">View Details <i class="fas fa-arrow-right"></i></a>
                </div>
                @endforeach
            </div>
            <div class="text-center">
                <a href="{{ url('/services') }}" class="btn btn-primary">View All Services</a>
            </div>
        </div>
    </section>

    <!-- Portfolio Preview -->
    <section class="section portfolio-preview">
        <div class="container">
            <div class="section-header">
                <h4 class="section-subtitle">Our Portfolio</h4>
                <h2 class="section-title">Recent Royal Celebrations</h2>
                <p class="section-description">A glimpse into the magical moments we've been privileged to capture.</p>
            </div>
            <div class="portfolio-filter">
                <button class="filter-btn active" data-filter="all">All</button>
                @foreach ($categories as $cat1)
                <button class="filter-btn" data-filter="{{ $cat1 }}">{{ ucfirst($cat1) }}</button>
                @endforeach
            </div>
            <div class="portfolio-grid">
                @foreach ($portfolio as $item)
                <div class="portfolio-item" data-category="{{ $item->category }}">
                    <img src="{{ asset('storage/' . $item->image_path) }}" alt="{{ $item->title }}" style="width:100%;height:100%;object-fit:cover;">
                    <div class="portfolio-overlay">
                        <h3>{{ $item->title }}</h3>
                        <p>{{ $item->location }}</p>
                    </div>
                </div>
                @endforeach
            </div>
            <div class="text-center">
                <a href="{{ url('/portfolio') }}" class="btn btn-outline">View Full Portfolio</a>
            </div>
        </div>
    </section>

    <!-- Quote Section -->
    <section class="quote-section">
        <div class="container">
            <div class="quote-content">
                <i class="fas fa-quote-left quote-icon"></i>
                <p class="quote-text">{{ $settings['quote_text'] }}</p>
                <p class="quote-author">— {{ $settings['quote_author'] }}</p>
            </div>
        </div>
    </section>

    <!-- Testimonials Preview -->
    <section class="section testimonials-preview">
        <div class="container">
            <div class="section-header">
                <h4 class="section-subtitle">Client Love</h4>
                <h2 class="section-title">What Our Couples Say</h2>
                <p class="section-description">Hear from the wonderful couples who entrusted us with their special day.</p>
            </div>
            <div class="testimonial-slider">
                @foreach ($reviews as $index => $review)
                <div class="testimonial-slide {{ $index === 0 ? 'active' : '' }}">
                    <div class="testimonial-card">
                        <div class="stars">
                            @for ($i = 1; $i <= $review->rating; $i++)
                                <i class="fas fa-star"></i>
                            @endfor
                        </div>
                        <p class="testimonial-text">"{{ $review->review_text }}"</p>
                        <div class="client-info">
                            @if ($review->client_image_url)
                                <img src="{{ $review->client_image_url }}" alt="{{ $review->client_name }}" style="width:50px;height:50px;border-radius:50%;object-fit:cover;">
                            @else
                                <div class="img-placeholder client-img"></div>
                            @endif
                            <div>
                                <h4>{{ $review->client_name }}</h4>
                                <p>{{ ucfirst($review->event_type) }} • {{ $review->event_location }}, {{ $review->event_year }}</p>
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
            <div class="testimonial-controls">
                <button class="testimonial-prev"><i class="fas fa-chevron-left"></i></button>
                <button class="testimonial-next"><i class="fas fa-chevron-right"></i></button>
            </div>
            <div class="text-center">
                <a href="{{ url('/reviews') }}" class="btn btn-outline">Read All Reviews</a>
            </div>
        </div>
    </section>

    <!-- CTA Section -->
    <section class="cta-section">
        <div class="container">
            <div class="cta-content">
                <h2 class="cta-title">Ready to Capture Your Royal Wedding?</h2>
                <p class="cta-description">Let's discuss your vision and create timeless memories together. Limited bookings available for 2025-2026.</p>
                <a href="{{ url('/contact') }}" class="btn btn-primary">Book a Consultation</a>
            </div>
        </div>
    </section>
@endsection
