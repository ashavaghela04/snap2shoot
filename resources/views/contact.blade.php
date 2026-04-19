@extends('layouts.app')

@section('content')
    <section class="page-header">
        <div class="container">
            <h1 class="page-title">Get In Touch</h1>
            <p class="page-subtitle">Let's discuss your wedding photography needs</p>
        </div>
    </section>

    <section class="section contact-section">
        <div class="container">
            {{-- FIX: Single success message, only here (removed duplicate inside form) --}}
            @if (session('success'))
            <div style="background:#d4edda;color:#155724;padding:15px 20px;border-radius:8px;margin-bottom:25px;border:1px solid #c3e6cb;">
                <i class="fas fa-check-circle"></i> {{ session('success') }}
            </div>
            @endif

            {{-- Show all validation errors in one place at top --}}
            @if ($errors->any())
            <div style="background:#f8d7da;color:#721c24;padding:15px 20px;border-radius:8px;margin-bottom:25px;border:1px solid #f5c6cb;">
                <i class="fas fa-exclamation-circle"></i> Please fix the following errors:
                <ul style="margin:8px 0 0 20px;">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
            @endif

            <div class="contact-grid">
                <!-- Contact Form -->
                <div class="contact-form-container">
                    <h2 class="form-title">Send us a Message</h2>
                    <form method="POST" action="{{ route('contact.submit') }}" id="contactForm" class="contact-form">
                        @csrf
                        
                        <div class="form-group">
                            <label for="name">Full Name *</label>
                            <input type="text" id="name" name="name" required placeholder="Your full name" value="{{ old('name') }}">
                            @error('name')<span style="color:red;font-size:0.85rem;">{{ $message }}</span>@enderror
                        </div>

                        <div class="form-row">
                            <div class="form-group">
                                <label for="email">Email Address *</label>
                                <input type="email" id="email" name="email" required placeholder="you@example.com" value="{{ old('email') }}">
                                @error('email')<span style="color:red;font-size:0.85rem;">{{ $message }}</span>@enderror
                            </div>
                            <div class="form-group">
                                <label for="phone">Phone Number *</label>
                                <input type="tel" id="phone" name="phone" required placeholder="+91 98765 43210" value="{{ old('phone') }}">
                                @error('phone')<span style="color:red;font-size:0.85rem;">{{ $message }}</span>@enderror
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="wedding-date">Wedding Date</label>
                            <input type="date" id="wedding-date" name="wedding_date" value="{{ old('wedding_date') }}">
                            @error('wedding_date')<span style="color:red;font-size:0.85rem;">{{ $message }}</span>@enderror
                        </div>

                        <div class="form-group">
                            <label for="service">Service Interested In</label>
                            <select id="service" name="service">
                                <option value="">Select a service</option>
                                @foreach ($services as $service)
                                <option value="{{ $service->slug }}" {{ old('service') == $service->slug ? 'selected' : '' }}>
                                    {{ $service->name }}
                                </option>
                                @endforeach
                                <option value="custom" {{ old('service') == 'custom' ? 'selected' : '' }}>Custom Package</option>
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="message">Your Message *</label>
                            <textarea id="message" name="message" rows="5" required placeholder="Tell us about your wedding plans, vision, and any specific requirements...">{{ old('message') }}</textarea>
                            @error('message')<span style="color:red;font-size:0.85rem;">{{ $message }}</span>@enderror
                        </div>

                        <div class="form-group">
                            <label class="checkbox-label">
                                <input type="checkbox" name="newsletter" {{ old('newsletter', 'checked') ? 'checked' : '' }}>
                                <span>Subscribe to our newsletter for tips and offers</span>
                            </label>
                        </div>

                        <button type="submit" class="btn btn-primary btn-submit">
                            <i class="fas fa-paper-plane"></i> Send Message
                        </button>
                    </form>
                </div>

                <!-- Contact Info -->
                <div class="contact-info">
                    <div class="info-card">
                        <h3>Contact Information</h3>
                        <div class="info-item">
                            <div class="info-icon"><i class="fas fa-map-marker-alt"></i></div>
                            <div class="info-content">
                                <h4>Studio Address</h4>
                                <p>{{ $settings['address'] }}</p>
                            </div>
                        </div>
                        <div class="info-item">
                            <div class="info-icon"><i class="fas fa-phone"></i></div>
                            <div class="info-content">
                                <h4>Phone Numbers</h4>
                                <p>{{ $settings['phone_primary'] }}<br>{{ $settings['phone_secondary'] }} (Office)</p>
                            </div>
                        </div>
                        <div class="info-item">
                            <div class="info-icon"><i class="fas fa-envelope"></i></div>
                            <div class="info-content">
                                <h4>Email Address</h4>
                                <p>{{ $settings['email_primary'] }}<br>{{ $settings['email_bookings'] }}</p>
                            </div>
                        </div>
                        <div class="info-item">
                            <div class="info-icon"><i class="fas fa-clock"></i></div>
                            <div class="info-content">
                                <h4>Working Hours</h4>
                                <p>{{ $settings['working_hours'] }}<br>Sunday: By appointment only</p>
                            </div>
                        </div>
                    </div>

                    <div class="quick-links">
                        <h3>Quick Connect</h3>
                        <div class="quick-buttons">
                            <a href="https://wa.me/{{ $settings['whatsapp_number'] }}" class="quick-btn whatsapp" target="_blank">
                                <i class="fab fa-whatsapp"></i> WhatsApp
                            </a>
                            <a href="tel:{{ $settings['phone_primary'] }}" class="quick-btn phone">
                                <i class="fas fa-phone"></i> Call Now
                            </a>
                            <a href="mailto:{{ $settings['email_primary'] }}" class="quick-btn email">
                                <i class="fas fa-envelope"></i> Email
                            </a>
                        </div>
                    </div>

                    <div class="social-connect">
                        <h3>Follow Us</h3>
                        <div class="social-icons">
                            <a href="{{ $settings['instagram_url'] }}" class="social-icon instagram"><i class="fab fa-instagram"></i></a>
                            <a href="{{ $settings['facebook_url'] }}" class="social-icon facebook"><i class="fab fa-facebook-f"></i></a>
                            <a href="{{ $settings['pinterest_url'] }}" class="social-icon pinterest"><i class="fab fa-twitter"></i></a>
                            <a href="{{ $settings['youtube_url'] }}" class="social-icon youtube"><i class="fab fa-youtube"></i></a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="booking-cta">
        <div class="container">
            <div class="booking-content">
                <h2>Ready to Book Your Session?</h2>
                <p>Limited dates available for 2025-2026. Contact us today to secure your date.</p>
                <div class="booking-buttons">
                    <a href="tel:{{ $settings['phone_primary'] }}" class="btn btn-primary">
                        <i class="fas fa-phone"></i> Call Now
                    </a>
                    <a href="https://wa.me/{{ $settings['whatsapp_number'] }}" class="btn btn-secondary" target="_blank">
                        <i class="fab fa-whatsapp"></i> WhatsApp
                    </a>
                </div>
            </div>
        </div>
    </section>
@endsection

