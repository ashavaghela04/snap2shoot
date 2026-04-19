@extends('layouts.app')

@section('content')
    <section class="page-header">
        <div class="container">
            <h1 class="page-title">Our Portfolio</h1>
            <p class="page-subtitle">A collection of beautiful moments captured with love and artistry</p>
        </div>
    </section>

    <section class="section portfolio-main">
        <div class="container">
            <div class="portfolio-filter">
                <button class="filter-btn active" data-filter="all">All</button>
                @foreach ($categories as $cat)
                <button class="filter-btn" data-filter="{{ $cat }}">{{ ucfirst($cat) }}</button>
                @endforeach
            </div>

            <div class="portfolio-grid-large">
                @foreach ($portfolio as $item)
                <div class="portfolio-item-large" data-category="{{ $item->category }}">
                    <img src="{{ asset('storage/' . $item->image_path) }}" alt="{{ $item->title }}" style="width:100%;height:100%;object-fit:cover;">
                    <div class="portfolio-overlay-large">
                        <h3>{{ $item->title }}</h3>
                        <p>{{ $item->location }} • {{ $item->description }}</p>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </section>

    <section class="cta-section">
        <div class="container">
            <div class="cta-content">
                <h2 class="cta-title">Love What You See?</h2>
                <p class="cta-description">Let us capture your special moments with the same passion and artistry.</p>
                <a href="{{ url('/contact') }}" class="btn btn-primary">Book a Session</a>
            </div>
        </div>
    </section>
@endsection
