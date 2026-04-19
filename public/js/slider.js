// Slider JavaScript

document.addEventListener('DOMContentLoaded', function() {
    // Video Slider
    const videoSlides = document.querySelectorAll('.video-slide');
    const videoControls = document.querySelectorAll('.video-control');
    let currentSlide = 0;
    let slideInterval;
    
    function changeVideoSlide(slideIndex) {
        // Remove active class from all slides and controls
        videoSlides.forEach(slide => slide.classList.remove('active'));
        videoControls.forEach(control => control.classList.remove('active'));
        
        // Add active class to current slide and control
        videoSlides[slideIndex].classList.add('active');
        videoControls[slideIndex].classList.add('active');
        
        currentSlide = slideIndex;
    }
    
    function nextVideoSlide() {
        currentSlide = (currentSlide + 1) % videoSlides.length;
        changeVideoSlide(currentSlide);
    }
    
    // Add click events to video controls
    videoControls.forEach((control, index) => {
        control.addEventListener('click', () => {
            clearInterval(slideInterval);
            changeVideoSlide(index);
            startVideoSlider();
        });
    });
    
    function startVideoSlider() {
        clearInterval(slideInterval);
        slideInterval = setInterval(nextVideoSlide, 7000);
    }
    
    // Initialize video slider
    if (videoSlides.length > 0) {
        startVideoSlider();
    }
    
    // Testimonial Slider
    const testimonialSlides = document.querySelectorAll('.testimonial-slide');
    const testimonialPrev = document.querySelector('.testimonial-prev');
    const testimonialNext = document.querySelector('.testimonial-next');
    let currentTestimonial = 0;
    
    function changeTestimonialSlide(slideIndex) {
        // Remove active class from all slides
        testimonialSlides.forEach(slide => slide.classList.remove('active'));
        
        // Add active class to current slide
        testimonialSlides[slideIndex].classList.add('active');
        
        currentTestimonial = slideIndex;
    }
    
    if (testimonialPrev && testimonialNext) {
        testimonialPrev.addEventListener('click', () => {
            currentTestimonial = (currentTestimonial - 1 + testimonialSlides.length) % testimonialSlides.length;
            changeTestimonialSlide(currentTestimonial);
        });
        
        testimonialNext.addEventListener('click', () => {
            currentTestimonial = (currentTestimonial + 1) % testimonialSlides.length;
            changeTestimonialSlide(currentTestimonial);
        });
    }
    
    // Initialize testimonial slider
    if (testimonialSlides.length > 0) {
        changeTestimonialSlide(0);
    }
    
    // Auto-play testimonial slider
    let testimonialInterval;
    
    function startTestimonialSlider() {
        clearInterval(testimonialInterval);
        testimonialInterval = setInterval(() => {
            currentTestimonial = (currentTestimonial + 1) % testimonialSlides.length;
            changeTestimonialSlide(currentTestimonial);
        }, 10000); // Change every 10 seconds
    }
    
    // Start auto-play if there are multiple slides
    if (testimonialSlides.length > 1) {
        startTestimonialSlider();
        
        // Pause on hover
        const testimonialSlider = document.querySelector('.testimonial-slider');
        if (testimonialSlider) {
            testimonialSlider.addEventListener('mouseenter', () => {
                clearInterval(testimonialInterval);
            });
            
            testimonialSlider.addEventListener('mouseleave', () => {
                startTestimonialSlider();
            });
        }
    }
    
    // Portfolio Image Slider (for mobile)
    const portfolioItems = document.querySelectorAll('.portfolio-item');
    let portfolioCurrent = 0;
    let portfolioInterval;
    
    function showPortfolioItem(index) {
        portfolioItems.forEach((item, i) => {
            if (i === index) {
                item.style.opacity = '1';
                item.style.transform = 'scale(1)';
            } else {
                item.style.opacity = '0';
                item.style.transform = 'scale(0.8)';
            }
        });
    }
    
    function startPortfolioSlider() {
        clearInterval(portfolioInterval);
        portfolioInterval = setInterval(() => {
            portfolioCurrent = (portfolioCurrent + 1) % portfolioItems.length;
            showPortfolioItem(portfolioCurrent);
        }, 5000);
    }
    
    // Only enable on mobile
    function checkScreenSize() {
        if (window.innerWidth <= 768 && portfolioItems.length > 0) {
            showPortfolioItem(0);
            startPortfolioSlider();
        } else {
            clearInterval(portfolioInterval);
            portfolioItems.forEach(item => {
                item.style.opacity = '1';
                item.style.transform = 'scale(1)';
            });
        }
    }
    
    // Check screen size on load and resize
    checkScreenSize();
    window.addEventListener('resize', checkScreenSize);
    
    // Add swipe functionality for mobile
    let touchStartX = 0;
    let touchEndX = 0;
    
    const portfolioContainer = document.querySelector('.portfolio-grid');
    if (portfolioContainer) {
        portfolioContainer.addEventListener('touchstart', e => {
            touchStartX = e.changedTouches[0].screenX;
        }, { passive: true });
        
        portfolioContainer.addEventListener('touchend', e => {
            touchEndX = e.changedTouches[0].screenX;
            handleSwipe();
        }, { passive: true });
    }
    
    function handleSwipe() {
        const swipeThreshold = 50;
        
        if (touchEndX < touchStartX - swipeThreshold) {
            // Swipe left - next item
            portfolioCurrent = (portfolioCurrent + 1) % portfolioItems.length;
            showPortfolioItem(portfolioCurrent);
            clearInterval(portfolioInterval);
            startPortfolioSlider();
        }
        
        if (touchEndX > touchStartX + swipeThreshold) {
            // Swipe right - previous item
            portfolioCurrent = (portfolioCurrent - 1 + portfolioItems.length) % portfolioItems.length;
            showPortfolioItem(portfolioCurrent);
            clearInterval(portfolioInterval);
            startPortfolioSlider();
        }
    }
    
    // Progress bar for sliders
    function createProgressBar(sliderElement, intervalTime) {
        const progressBar = document.createElement('div');
        progressBar.className = 'slider-progress';
        progressBar.style.cssText = `
            position: absolute;
            bottom: 0;
            left: 0;
            width: 100%;
            height: 3px;
            background: rgba(255, 255, 255, 0.3);
            overflow: hidden;
        `;
        
        const progress = document.createElement('div');
        progress.style.cssText = `
            width: 0;
            height: 100%;
            background: var(--gold-accent);
            transition: width ${intervalTime/1000}s linear;
        `;
        
        progressBar.appendChild(progress);
        sliderElement.style.position = 'relative';
        sliderElement.appendChild(progressBar);
        
        return progress;
    }
    
    // Add progress bars to sliders
    if (videoSlides.length > 0) {
        const videoProgress = createProgressBar(document.querySelector('.video-slider'), 7000);
        
        // Update progress bar
        function updateVideoProgress() {
            videoProgress.style.width = '0';
            setTimeout(() => {
                videoProgress.style.width = '100%';
            }, 10);
        }
        
        // Start progress bar
        updateVideoProgress();
        
        // Update on slide change
        const originalChangeSlide = changeVideoSlide;
        changeVideoSlide = function(slideIndex) {
            originalChangeSlide(slideIndex);
            updateVideoProgress();
        };
        
        // Reset progress bar when manually changing slides
        videoControls.forEach(control => {
            control.addEventListener('click', updateVideoProgress);
        });
    }
    
    // Lazy loading for slider images
    const lazyImages = document.querySelectorAll('img[data-src]');
    
    const imageObserver = new IntersectionObserver((entries, observer) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                const img = entry.target;
                img.src = img.dataset.src;
                img.removeAttribute('data-src');
                observer.unobserve(img);
            }
        });
    });
    
    lazyImages.forEach(img => imageObserver.observe(img));
    
    // Keyboard navigation for sliders
    document.addEventListener('keydown', (e) => {
        // Left arrow key - previous slide
        if (e.key === 'ArrowLeft') {
            if (testimonialPrev) testimonialPrev.click();
        }
        
        // Right arrow key - next slide
        if (e.key === 'ArrowRight') {
            if (testimonialNext) testimonialNext.click();
        }
        
        // Space bar - pause/resume auto-play
        if (e.key === ' ') {
            e.preventDefault();
            if (testimonialInterval) {
                clearInterval(testimonialInterval);
                testimonialInterval = null;
            } else {
                startTestimonialSlider();
            }
        }
    });
    
    // Add slide numbers to testimonial slider
    if (testimonialSlides.length > 0) {
        const slideNumbers = document.createElement('div');
        slideNumbers.className = 'slide-numbers';
        slideNumbers.style.cssText = `
            text-align: center;
            margin-top: 20px;
            color: var(--text-secondary);
            font-size: 0.9rem;
        `;
        
        slideNumbers.innerHTML = `
            <span class="current-slide">1</span> / <span class="total-slides">${testimonialSlides.length}</span>
        `;
        
        const testimonialContainer = document.querySelector('.testimonial-slider');
        if (testimonialContainer) {
            testimonialContainer.parentNode.insertBefore(slideNumbers, testimonialContainer.nextSibling);
            
            // Update slide numbers
            const currentSlideSpan = slideNumbers.querySelector('.current-slide');
            const updateSlideNumbers = () => {
                currentSlideSpan.textContent = currentTestimonial + 1;
            };
            
            updateSlideNumbers();
            
            // Update on slide change
            const originalChangeTestimonial = changeTestimonialSlide;
            changeTestimonialSlide = function(slideIndex) {
                originalChangeTestimonial(slideIndex);
                updateSlideNumbers();
            };
        }
    }
    
    // Preload slider images
    function preloadImages() {
        const images = [];
        
        // Add all slider images to preload
        document.querySelectorAll('.video-fallback, .portfolio-item .img-placeholder').forEach(el => {
            const bgImage = window.getComputedStyle(el).backgroundImage;
            const urlMatch = bgImage.match(/url\(["']?([^"']+)["']?\)/);
            if (urlMatch && urlMatch[1]) {
                images.push(urlMatch[1]);
            }
        });
        
        // Preload images
        images.forEach(src => {
            const img = new Image();
            img.src = src;
        });
    }
    
    // Start preloading after page load
    window.addEventListener('load', preloadImages);
});