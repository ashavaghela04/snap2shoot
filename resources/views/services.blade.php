@extends('layouts.app')

@section('content')
    <!-- Page Header -->
    <section class="page-header">
        <div class="container">
            <h1 class="page-title">Our Services</h1>
            <p class="page-subtitle">Comprehensive wedding photography packages tailored to your needs</p>
        </div>
    </section>

    <!-- Services Grid -->
    <section class="section services-detail">
        <div class="container">
            <div class="service-cards">
                @foreach ($services as $service)
                <div class="service-detail-card" id="{{ $service->slug }}">
                    <div class="service-detail-header">
                        <div class="service-icon">
                            <i class="{{ $service->icon }}"></i>
                        </div>
                        <div>
                            <h2 class="service-title">{{ $service->name }}</h2>
                            <p class="service-price">{{ $service->price_label }}</p>
                        </div>
                    </div>
                    <div class="service-detail-content">
                        <p>{{ $service->description }}</p>
                        @if ($service->features)
                        <div class="service-features">
                            <h3>Package Includes:</h3>
                            <ul>
                                @foreach ($service->features as $feature)
                                <li><i class="fas fa-check"></i> {{ $feature }}</li>
                                @endforeach
                            </ul>
                        </div>
                        @endif
                        <a href="javascript:void(0);" class="btn btn-primary">Book This Package</a>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </section>

    <!-- Process Section -->
    <section class="section process-section">
        <div class="container">
            <div class="section-header">
                <h4 class="section-subtitle">Our Process</h4>
                <h2 class="section-title">How We Work</h2>
                <p class="section-description">A seamless journey from booking to final delivery</p>
            </div>
            <div class="process-steps">
                <div class="process-step">
                    <div class="step-number">1</div>
                    <h3>Consultation</h3>
                    <p>We meet to understand your vision, timeline, and preferences</p>
                </div>
                <div class="process-step">
                    <div class="step-number">2</div>
                    <h3>Planning</h3>
                    <p>We create a customized photography plan for your special day</p>
                </div>
                <div class="process-step">
                    <div class="step-number">3</div>
                    <h3>Shoot Day</h3>
                    <p>Our team captures every moment with professionalism and creativity</p>
                </div>
                <div class="process-step">
                    <div class="step-number">4</div>
                    <h3>Editing</h3>
                    <p>We carefully edit and enhance your images to perfection</p>
                </div>
                <div class="process-step">
                    <div class="step-number">5</div>
                    <h3>Delivery</h3>
                    <p>You receive your beautiful images and albums to cherish forever</p>
                </div>
            </div>
        </div>
    </section>

    <!-- CTA Section -->
    <section class="cta-section">
        <div class="container">
            <div class="cta-content">
                <h2 class="cta-title">Ready to Discuss Your Special Day?</h2>
                <p class="cta-description">Contact us for a personalized consultation and custom quote</p>
                <a href="{{ url('/contact') }}" class="btn btn-primary">Get in Touch</a>
            </div>
        </div>
    </section>
@endsection
