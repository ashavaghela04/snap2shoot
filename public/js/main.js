// Main JavaScript File

document.addEventListener('DOMContentLoaded', function () {

    // ─── Helper: show inline form messages ───────────────────────────────────
    // FIX 1: Defined at the TOP of DOMContentLoaded so it's always in scope
    // FIX 2: Creates the message element if it doesn't exist in the HTML
    function showFormMessage(msg, type) {
        let formMessage = document.getElementById('formMessage');

        if (!formMessage) {
            formMessage = document.createElement('div');
            formMessage.id = 'formMessage';
            formMessage.style.cssText = 'margin-top:15px;padding:12px 18px;border-radius:8px;font-size:0.95rem;';
            const form = document.getElementById('contactForm');
            if (form) form.appendChild(formMessage);
        }

        formMessage.textContent = msg;
        formMessage.style.display = 'block';

        if (type === 'error') {
            formMessage.style.background = '#f8d7da';
            formMessage.style.color = '#721c24';
            formMessage.style.border = '1px solid #f5c6cb';
        } else {
            formMessage.style.background = '#d4edda';
            formMessage.style.color = '#155724';
            formMessage.style.border = '1px solid #c3e6cb';
        }
    }

    function validateEmail(email) {
        return /^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(email);
    }

    function validatePhone(phone) {
        return /^[\d\s\+\-\(\)]{10,}$/.test(phone);
    }

    // ─── Mobile Menu Toggle ───────────────────────────────────────────────────
    const mobileMenuBtn = document.querySelector('.mobile-menu-btn');
    const navMenu = document.querySelector('.nav-menu');

    if (mobileMenuBtn) {
        mobileMenuBtn.addEventListener('click', function () {
            navMenu.classList.toggle('active');
            this.innerHTML = navMenu.classList.contains('active')
                ? '<i class="fas fa-times"></i>'
                : '<i class="fas fa-bars"></i>';
        });
    }

    document.querySelectorAll('.nav-link').forEach(link => {
        link.addEventListener('click', () => {
            if (navMenu) navMenu.classList.remove('active');
            if (mobileMenuBtn) mobileMenuBtn.innerHTML = '<i class="fas fa-bars"></i>';
        });
    });

    // ─── Animated Counters ────────────────────────────────────────────────────
    const counters = document.querySelectorAll('.stat-number');

    const animateCounter = (counter) => {
        const target = parseInt(counter.getAttribute('data-count'));
        const increment = target / 200;
        let current = 0;

        const updateCounter = () => {
            if (current < target) {
                current += increment;
                counter.textContent = Math.ceil(current);
                setTimeout(updateCounter, 10);
            } else {
                counter.textContent = target + '+';
            }
        };
        updateCounter();
    };

    const counterObserver = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                animateCounter(entry.target);
                counterObserver.unobserve(entry.target);
            }
        });
    }, { threshold: 0.5 });

    counters.forEach(counter => {
        if (counter.hasAttribute('data-count')) counterObserver.observe(counter);
    });

    // ─── Lightbox ─────────────────────────────────────────────────────────────
    const lightbox = document.querySelector('.lightbox');
    const lightboxImg = document.querySelector('.lightbox-img');
    const lightboxTitle = document.querySelector('.lightbox-title');
    const lightboxDescription = document.querySelector('.lightbox-description');
    const lightboxClose = document.querySelector('.lightbox-close');

    document.querySelectorAll('.portfolio-item, .gallery-item, .review-img').forEach(item => {
        item.addEventListener('click', function () {
            if (!lightbox) return;
            const img = this.querySelector('img')?.src || '';
            const title = this.querySelector('h3')?.textContent || 'Image Preview';
            const description = this.querySelector('p')?.textContent || '';

            if (lightboxImg) {
                lightboxImg.src = img || 'data:image/svg+xml;base64,PHN2ZyB3aWR0aD0iNjAwIiBoZWlnaHQ9IjQwMCIgeG1sbnM9Imh0dHA6Ly93d3cudzMub3JnLzIwMDAvc3ZnIj48cmVjdCB3aWR0aD0iMTAwJSIgaGVpZ2h0PSIxMDAlIiBmaWxsPSIjZjNmYmUzIi8+PHRleHQgeD0iNTAlIiB5PSI1MCUiIGZvbnQtZmFtaWx5PSJBcmlhbCIgZm9udC1zaXplPSIyNCIgdGV4dC1hbmNob3I9Im1pZGRsZSIgZmlsbD0iI2E4MzIzZSI+U3R1ZGlvPC90ZXh0Pjwvc3ZnPg==';
            }
            if (lightboxTitle) lightboxTitle.textContent = title;
            if (lightboxDescription) lightboxDescription.textContent = description;

            lightbox.classList.add('active');
            document.body.style.overflow = 'hidden';
        });
    });

    if (lightboxClose) {
        lightboxClose.addEventListener('click', () => {
            lightbox.classList.remove('active');
            document.body.style.overflow = 'auto';
        });
    }

    if (lightbox) {
        lightbox.addEventListener('click', (e) => {
            if (e.target === lightbox) {
                lightbox.classList.remove('active');
                document.body.style.overflow = 'auto';
            }
        });
    }

    document.addEventListener('keydown', (e) => {
        if (e.key === 'Escape' && lightbox?.classList.contains('active')) {
            lightbox.classList.remove('active');
            document.body.style.overflow = 'auto';
        }
    });

    // ─── Smooth Scrolling ─────────────────────────────────────────────────────
    document.querySelectorAll('a[href^="#"]').forEach(anchor => {
        anchor.addEventListener('click', function (e) {
            const targetId = this.getAttribute('href');
            if (targetId === '#' || targetId === '#!') return;
            const targetElement = document.querySelector(targetId);
            if (targetElement) {
                e.preventDefault();
                window.scrollTo({ top: targetElement.offsetTop - 80, behavior: 'smooth' });
            }
        });
    });

    // ─── Navbar on Scroll ─────────────────────────────────────────────────────
    window.addEventListener('scroll', function () {
        const navbar = document.querySelector('.navbar');
        if (!navbar) return;
        if (window.scrollY > 100) {
            navbar.style.background = 'rgba(253, 247, 242, 0.98)';
            navbar.style.boxShadow = '0 5px 20px rgba(0,0,0,0.05)';
        } else {
            navbar.style.background = 'rgba(253, 247, 242, 0.95)';
            navbar.style.boxShadow = 'none';
        }
    });

    // ─── FAQ Accordion ────────────────────────────────────────────────────────
    document.querySelectorAll('.faq-question').forEach(question => {
        question.addEventListener('click', function () {
            const answer = this.nextElementSibling;
            const isActive = this.classList.contains('active');

            document.querySelectorAll('.faq-question').forEach(q => {
                q.classList.remove('active');
                if (q.nextElementSibling) q.nextElementSibling.classList.remove('active');
            });

            if (!isActive) {
                this.classList.add('active');
                if (answer) answer.classList.add('active');
            }
        });
    });

    // ─── Contact Form — Client-Side Validation ────────────────────────────────
    // FIX 3: Removed e.preventDefault() so the form actually POSTs to Laravel.
    //         We only prevent submission when validation FAILS.
    //         Laravel handles the real submission, saving to DB, and redirecting.
    const contactForm = document.getElementById('contactForm');
    if (contactForm) {
        contactForm.addEventListener('submit', function (e) {
            const name = document.getElementById('name')?.value.trim() || '';
            const email = document.getElementById('email')?.value.trim() || '';
            const phone = document.getElementById('phone')?.value.trim() || '';
            const message = document.getElementById('message')?.value.trim() || '';

            // Only block submit if client-side validation fails
            if (!name || !email || !phone || !message) {
                e.preventDefault();
                showFormMessage('Please fill in all required fields.', 'error');
                return;
            }

            if (!validateEmail(email)) {
                e.preventDefault();
                showFormMessage('Please enter a valid email address.', 'error');
                return;
            }

            if (!validatePhone(phone)) {
                e.preventDefault();
                showFormMessage('Please enter a valid phone number (at least 10 digits).', 'error');
                return;
            }

            // ✅ Validation passed — let the form submit naturally to Laravel
            // Show a "sending" indicator while the page posts
            const submitBtn = contactForm.querySelector('[type="submit"]');
            if (submitBtn) {
                submitBtn.disabled = true;
                submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Sending...';
            }
        });
    }

    // ─── Load More Reviews ────────────────────────────────────────────────────
    const loadMoreReviewsBtn = document.getElementById('load-more-reviews');
    if (loadMoreReviewsBtn) {
        loadMoreReviewsBtn.addEventListener('click', function () {
            this.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Loading...';
            setTimeout(() => {
                this.innerHTML = 'No More Reviews';
                this.disabled = true;
                this.style.opacity = '0.5';
            }, 1500);
        });
    }

    // ─── Portfolio Gallery View ───────────────────────────────────────────────
    document.querySelectorAll('.view-gallery-btn').forEach(btn => {
        btn.addEventListener('click', function () {
            const gallery = document.getElementById(`${this.getAttribute('data-category')}-gallery`);
            if (gallery) {
                gallery.style.display = 'block';
                gallery.scrollIntoView({ behavior: 'smooth' });
            }
        });
    });

    document.querySelectorAll('.close-gallery').forEach(btn => {
        btn.addEventListener('click', function () {
            const gallery = this.closest('.category-gallery');
            if (gallery) gallery.style.display = 'none';
        });
    });

    // ─── Video Play Button ────────────────────────────────────────────────────
    document.querySelectorAll('.play-button').forEach(btn => {
        btn.addEventListener('click', function () {
            alert('Video playback would start here.');
        });
    });

    // ─── Scroll to Top Button ─────────────────────────────────────────────────
    const scrollTopBtn = document.createElement('button');
    scrollTopBtn.innerHTML = '<i class="fas fa-chevron-up"></i>';
    scrollTopBtn.className = 'scroll-top-btn';
    scrollTopBtn.style.cssText = `
        position:fixed;bottom:100px;right:30px;width:50px;height:50px;
        background:var(--primary-maroon);color:white;border:none;border-radius:50%;
        font-size:1.2rem;cursor:pointer;opacity:0;visibility:hidden;
        transition:all 0.3s ease;z-index:1000;display:flex;
        align-items:center;justify-content:center;
        box-shadow:0 5px 15px rgba(122,31,43,0.3);
    `;
    document.body.appendChild(scrollTopBtn);

    window.addEventListener('scroll', () => {
        const visible = window.scrollY > 500;
        scrollTopBtn.style.opacity = visible ? '1' : '0';
        scrollTopBtn.style.visibility = visible ? 'visible' : 'hidden';
    });

    scrollTopBtn.addEventListener('click', () => window.scrollTo({ top: 0, behavior: 'smooth' }));
    scrollTopBtn.addEventListener('mouseenter', () => {
        scrollTopBtn.style.transform = 'translateY(-3px)';
        scrollTopBtn.style.boxShadow = '0 8px 25px rgba(122,31,43,0.4)';
    });
    scrollTopBtn.addEventListener('mouseleave', () => {
        scrollTopBtn.style.transform = 'translateY(0)';
        scrollTopBtn.style.boxShadow = '0 5px 15px rgba(122,31,43,0.3)';
    });

    // ─── Footer Copyright Year ────────────────────────────────────────────────
    const currentYear = new Date().getFullYear();
    document.querySelectorAll('.copyright').forEach(el => {
        el.textContent = el.textContent.replace(/\d{4}/, currentYear);
    });

    // ─── Service Links ────────────────────────────────────────────────────────
    document.querySelectorAll('.service-link').forEach(link => {
        link.addEventListener('click', function (e) {
            const href = this.getAttribute('href') || '';
            if (href.startsWith('services.html#')) {
                e.preventDefault();
                window.location.href = href;
            }
        });
    });

    // ─── Scroll-triggered Animations ─────────────────────────────────────────
    const elementObserver = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.style.animationPlayState = 'running';
                elementObserver.unobserve(entry.target);
            }
        });
    }, { threshold: 0.1 });

    document.querySelectorAll('.fade-in-up, .fade-in-down, .fade-in-left, .fade-in-right, .scale-in').forEach(el => {
        el.style.animationPlayState = 'paused';
        elementObserver.observe(el);
    });

    // ─── Active Nav Link ──────────────────────────────────────────────────────
    const currentPage = window.location.pathname.split('/').pop();
    document.querySelectorAll('.nav-link').forEach(link => {
        const linkPage = link.getAttribute('href');
        if (linkPage === currentPage || (currentPage === '' && linkPage === 'index.html')) {
            link.classList.add('active');
        } else {
            link.classList.remove('active');
        }
    });

}); // end DOMContentLoaded

