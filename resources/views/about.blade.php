@extends('layouts.app')

@section('content')
    <section class="page-header">
        <div class="container">
            <h1 class="page-title">About Snap2Shoot</h1>
            <p class="page-subtitle">Our journey in capturing love stories since 2015</p>
        </div>
    </section>

    <!-- Our Story -->
    <section class="section story-section">
        <div class="container">
            <div class="story-content">
                <div class="story-text">
                    <h2 class="section-title">Our Story</h2>
                    <p>{{ $settings['about_story'] }}</p>
                    <p>Our philosophy is simple: every wedding is a royal celebration deserving of royal treatment. We approach each assignment not just as photographers, but as storytellers, historians, and artists.</p>
                    <div class="about-stats" style="margin-top:30px;">
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
                </div>
                <div class="story-image">
                    <div class="img-placeholder story-img"><img src="{{ asset('images/photographer.jpg') }}" alt="Photographer" ></div>
                </div>
            </div>
        </div>
    </section>

    <!-- Team Section -->
    <section class="section team-section">
        <div class="container">
            <div class="section-header">
                <h4 class="section-subtitle">Our Team</h4>
                <h2 class="section-title">Meet Your Photographers</h2>
                <p class="section-description">A dedicated team of artists passionate about capturing your special moments</p>
            </div>
            <div class="team-grid">
                @foreach ($team as $member)
                <div class="team-member">
                    <div class="member-img">
                        @if ($member->image_url)
                            <img src="{{ $member->image_url ? asset('storage/'.$member->image_url) : asset('images/default-user.jpg') }}"
                     class="tm-avatar" alt="{{ $member->name }}">    @else
                            <div class="img-placeholder"></div>
                        @endif
                    </div>
                    <div class="member-info">
                        <h3>{{ $member->name }}</h3>
                        <p class="member-role">{{ $member->role }}</p>
                        <p>{{ $member->bio }}</p>
                        <div class="member-social">
                            @if ($member->instagram_url)
                                <a href="{{ $member->instagram_url }}"><i class="fab fa-instagram"></i></a>
                            @endif
                            @if ($member->facebook_url)
                                <a href="{{ $member->facebook_url }}"><i class="fab fa-facebook-f"></i></a>
                            @endif
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </section>

    <section class="cta-section">
        <div class="container">
            <div class="cta-content">
                <h2 class="cta-title">Ready to Work With Us?</h2>
                <p class="cta-description">Let's create timeless memories of your special day together.</p>
                <a href="{{ url('/contact') }}" class="btn btn-primary">Book a Consultation</a>
            </div>
        </div>
    </section>
@endsection
