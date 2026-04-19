<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Snap2Shoot - Luxury Wedding Photography | Ahmedabad</title>
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('css/animations.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:wght@300;400;500;600;700&family=Inter:wght@300;400;500;600&display=swap" rel="stylesheet">
</head>
<body>
    <!-- Navigation -->
    <nav class="navbar" id="navbar">
        <div class="container">
            <a href="{{ url('/') }}" class="logo">
                <img src="{{ asset('images/logo.png') }}" alt="Snap2Shoot Logo" class="logo-img">
            </a>
            <div class="nav-menu" id="navMenu">
               <a href="{{ url('/') }}"         class="nav-link {{ request()->is('/') ? 'active' : '' }}">Home</a>
                <a href="{{ url('/about') }}"    class="nav-link {{ request()->is('about') ? 'active' : '' }}">About</a>
                <a href="{{ url('/services') }}" class="nav-link {{ request()->is('services') ? 'active' : '' }}">Services</a>
                <a href="{{ url('/portfolio') }}" class="nav-link {{ request()->is('portfolio') ? 'active' : '' }}">Portfolio</a>
                <a href="{{ url('/reviews') }}"  class="nav-link {{ request()->is('reviews') ? 'active' : '' }}">Reviews</a>
                <a href="{{ url('/contact') }}"  class="nav-link {{ request()->is('contact') ? 'active' : '' }}">Contact</a>
                <a href="{{ url('/login') }}" class="nav-link admin-btn"><i class="fas fa-lock"></i> </a>
            </div>
            <button class="mobile-menu-btn"><i class="fas fa-bars"></i></button>
        </div>
    </nav>

    @yield('content')

    <!-- Footer -->
    <footer class="footer">
        <div class="container">
            <div class="footer-grid">
                <div class="footer-col">
                    <a href="{{ url('/') }}" class="footer-logo">Snap2Shoot</a>
                    <p class="footer-about">Ahmedabad's premier luxury wedding photography studio specializing in capturing royal moments with timeless elegance.</p>
                    <div class="social-links">
                        <a href="{{ $settings['instagram_url'] }}"><i class="fab fa-instagram"></i></a>
                        <a href="{{ $settings['facebook_url'] }}"><i class="fab fa-facebook-f"></i></a>
                        <a href="{{ $settings['pinterest_url'] }}"><i class="fab fa-twitter"></i></a>
                        <a href="{{ $settings['youtube_url'] }}"><i class="fab fa-youtube"></i></a>
                    </div>
                </div>
                <div class="footer-col">
                    <h3 class="footer-title">Quick Links</h3>
                    <ul class="footer-links">
                        <li><a href="{{ url('/') }}">Home</a></li>
                        <li><a href="{{ url('/about') }}">About Us</a></li>
                        <li><a href="{{ url('/services') }}">Services</a></li>
                        <li><a href="{{ url('/portfolio') }}">Portfolio</a></li>
                        <li><a href="{{ url('/reviews') }}">Reviews</a></li>
                    </ul>
                </div>
                <div class="footer-col">
                    <h3 class="footer-title">Services</h3>
                    <ul class="footer-links">
                        <li><a href="{{ url('/services#royal') }}">Royal Wedding Coverage</a></li>
                        <li><a href="{{ url('/services#prewedding') }}">Pre-Wedding Shoot</a></li>
                        <li><a href="{{ url('/services#cinematic') }}">Cinematic Wedding Film</a></li>
                        <li><a href="{{ url('/services#maternity') }}">Maternity Shoot</a></li>
                    </ul>
                </div>
                <div class="footer-col">
                    <h3 class="footer-title">Contact Us</h3>
                    <ul class="footer-contact">
                        <li><i class="fas fa-map-marker-alt"></i> MG Road, Ahmedabad, Gujarat</li>
                        <li><i class="fas fa-phone"></i> +91 98765 43210</li>
                        <li><i class="fas fa-envelope"></i> hello@snap2shoot.com</li>
                        <li><i class="fas fa-clock"></i> Mon-Sat: 10AM - 7PM</li>
                    </ul>
                </div>
            </div>
            <div class="footer-bottom">
                <p class="copyright">© {{ date('Y') }} Snap2Shoot Wedding Photography. All rights reserved.</p>
                <div class="footer-legal">
                    <a href="#">Privacy Policy</a>
                    <a href="#">Terms of Service</a>
                </div>
            </div>
        </div>
    </footer>

    <!-- WhatsApp Floating Button -->
    <a href="https://wa.me/919876543210" class="whatsapp-float" target="_blank">
        <i class="fab fa-whatsapp"></i>
    </a>

    <!-- Lightbox Modal -->
    <div class="lightbox">
        <div class="lightbox-content">
            <button class="lightbox-close"><i class="fas fa-times"></i></button>
            <img src="" alt="" class="lightbox-img">
            <div class="lightbox-info">
                <h3 class="lightbox-title"></h3>
                <p class="lightbox-description"></p>
            </div>
        </div>
    </div>

    <script src="{{ asset('js/main.js') }}"></script>
    <script src="{{ asset('js/slider.js') }}"></script>
    <script src="{{ asset('js/filter.js') }}"></script>
    @yield('script')
</body>
</html>
