// Filter JavaScript

document.addEventListener('DOMContentLoaded', function() {
    // Portfolio Filter
    const portfolioFilterButtons = document.querySelectorAll('.portfolio-filter .filter-btn');
    const portfolioItems = document.querySelectorAll('.portfolio-item, .portfolio-item-large');
    
    if (portfolioFilterButtons.length > 0 && portfolioItems.length > 0) {
        portfolioFilterButtons.forEach(button => {
            button.addEventListener('click', function() {
                // Remove active class from all buttons
                portfolioFilterButtons.forEach(btn => btn.classList.remove('active'));
                
                // Add active class to clicked button
                this.classList.add('active');
                
                const filterValue = this.getAttribute('data-filter');
                
                // Show/hide portfolio items based on filter
                portfolioItems.forEach(item => {
                    const category = item.getAttribute('data-category');
                    
                    if (filterValue === 'all' || category === filterValue) {
                        item.style.display = 'block';
                        setTimeout(() => {
                            item.style.opacity = '1';
                            item.style.transform = 'scale(1)';
                            item.style.transition = 'opacity 0.3s ease, transform 0.3s ease';
                        }, 10);
                    } else {
                        item.style.opacity = '0';
                        item.style.transform = 'scale(0.8)';
                        setTimeout(() => {
                            item.style.display = 'none';
                        }, 300);
                    }
                });
                
                // Update URL hash for deep linking
                if (filterValue !== 'all') {
                    window.history.replaceState(null, null, `#${filterValue}`);
                } else {
                    window.history.replaceState(null, null, window.location.pathname);
                }
            });
        });
        
        // Check URL hash on page load
        const hash = window.location.hash.substring(1);
        if (hash) {
            const button = document.querySelector(`.portfolio-filter .filter-btn[data-filter="${hash}"]`);
            if (button) {
                button.click();
            }
        }
    }
    
    // Reviews Filter
    const reviewsFilterButtons = document.querySelectorAll('.reviews-filter .filter-btn');
    const reviewCards = document.querySelectorAll('.review-card');
    
    if (reviewsFilterButtons.length > 0 && reviewCards.length > 0) {
        reviewsFilterButtons.forEach(button => {
            button.addEventListener('click', function() {
                // Remove active class from all buttons
                reviewsFilterButtons.forEach(btn => btn.classList.remove('active'));
                
                // Add active class to clicked button
                this.classList.add('active');
                
                const filterValue = this.getAttribute('data-filter');
                
                // Animate out all reviews
                reviewCards.forEach(card => {
                    card.style.opacity = '0';
                    card.style.transform = 'translateY(20px)';
                    card.style.transition = 'opacity 0.3s ease, transform 0.3s ease';
                });
                
                // After animation, show filtered reviews
                setTimeout(() => {
                    reviewCards.forEach(card => {
                        const category = card.getAttribute('data-category');
                        
                        if (filterValue === 'all' || category === filterValue) {
                            card.style.display = 'block';
                            setTimeout(() => {
                                card.style.opacity = '1';
                                card.style.transform = 'translateY(0)';
                            }, 10);
                        } else {
                            card.style.display = 'none';
                        }
                    });
                }, 300);
                
                // Scroll to reviews section
                const reviewsSection = document.querySelector('.testimonials-grid');
                if (reviewsSection) {
                    reviewsSection.scrollIntoView({ behavior: 'smooth', block: 'start' });
                }
            });
        });
    }
    
    // Service Filter for Services Page
    const serviceLinks = document.querySelectorAll('a[href^="services.html#"]');
    serviceLinks.forEach(link => {
        link.addEventListener('click', function(e) {
            const targetId = this.getAttribute('href').split('#')[1];
            const targetElement = document.getElementById(targetId);
            
            if (targetElement) {
                e.preventDefault();
                
                // Scroll to the service
                window.scrollTo({
                    top: targetElement.offsetTop - 100,
                    behavior: 'smooth'
                });
                
                // Add highlight effect
                targetElement.classList.add('highlight');
                setTimeout(() => {
                    targetElement.classList.remove('highlight');
                }, 2000);
            }
        });
    });
    
    // Add highlight animation CSS
    const style = document.createElement('style');
    style.textContent = `
        .highlight {
            animation: highlightPulse 2s ease;
        }
        
        @keyframes highlightPulse {
            0% {
                box-shadow: 0 0 0 0 rgba(201, 162, 77, 0.4);
            }
            70% {
                box-shadow: 0 0 0 20px rgba(201, 162, 77, 0);
            }
            100% {
                box-shadow: 0 0 0 0 rgba(201, 162, 77, 0);
            }
        }
    `;
    document.head.appendChild(style);
    
    // Load More functionality for portfolio
    const loadMoreBtn = document.getElementById('load-more');
    if (loadMoreBtn) {
        let currentItems = 6; // Initial number of items shown
        const totalItems = document.querySelectorAll('.portfolio-item-large').length;
        
        // Hide items beyond initial count
        document.querySelectorAll('.portfolio-item-large').forEach((item, index) => {
            if (index >= currentItems) {
                item.style.display = 'none';
            }
        });
        
        loadMoreBtn.addEventListener('click', function() {
            // Show next 3 items
            const itemsToShow = Array.from(document.querySelectorAll('.portfolio-item-large'))
                .slice(currentItems, currentItems + 3);
            
            itemsToShow.forEach(item => {
                item.style.display = 'block';
                setTimeout(() => {
                    item.style.opacity = '1';
                    item.style.transform = 'translateY(0)';
                }, 10);
            });
            
            currentItems += 3;
            
            // Hide button if all items are shown
            if (currentItems >= totalItems) {
                this.style.display = 'none';
            }
        });
    }
    
    // Filter by date for portfolio (if date attributes are added)
    const portfolioItemsWithDates = document.querySelectorAll('[data-date]');
    if (portfolioItemsWithDates.length > 0) {
        // This is a placeholder for date filtering functionality
        // In a real implementation, you would add date pickers and filter logic here
    }
    
    // Advanced filtering for portfolio
    function advancedFilter(criteria) {
        portfolioItems.forEach(item => {
            let shouldShow = true;
            
            // Check each criterion
            if (criteria.category && criteria.category !== 'all') {
                const category = item.getAttribute('data-category');
                if (category !== criteria.category) {
                    shouldShow = false;
                }
            }
            
            if (criteria.year) {
                const date = item.getAttribute('data-date');
                if (date && !date.includes(criteria.year)) {
                    shouldShow = false;
                }
            }
            
            if (criteria.location) {
                const location = item.getAttribute('data-location');
                if (location && !location.toLowerCase().includes(criteria.location.toLowerCase())) {
                    shouldShow = false;
                }
            }
            
            // Apply filtering
            if (shouldShow) {
                item.style.display = 'block';
                setTimeout(() => {
                    item.style.opacity = '1';
                    item.style.transform = 'scale(1)';
                }, 10);
            } else {
                item.style.opacity = '0';
                item.style.transform = 'scale(0.8)';
                setTimeout(() => {
                    item.style.display = 'none';
                }, 300);
            }
        });
    }
    
    // Search functionality for portfolio
    const searchInput = document.createElement('input');
    searchInput.type = 'text';
    searchInput.placeholder = 'Search portfolio...';
    searchInput.className = 'portfolio-search';
    searchInput.style.cssText = `
        padding: 10px 15px;
        border: 2px solid var(--border-color);
        border-radius: 30px;
        width: 100%;
        max-width: 300px;
        margin: 0 auto 30px;
        display: block;
        font-family: var(--font-body);
        transition: all 0.3s ease;
    `;
    
    const portfolioFilter = document.querySelector('.portfolio-filter');
    if (portfolioFilter) {
        portfolioFilter.parentNode.insertBefore(searchInput, portfolioFilter.nextSibling);
        
        searchInput.addEventListener('input', function() {
            const searchTerm = this.value.toLowerCase().trim();
            
            if (searchTerm.length === 0) {
                // Reset to current filter
                const activeButton = document.querySelector('.portfolio-filter .filter-btn.active');
                if (activeButton) {
                    activeButton.click();
                }
                return;
            }
            
            portfolioItems.forEach(item => {
                const title = item.querySelector('h3')?.textContent.toLowerCase() || '';
                const description = item.querySelector('p')?.textContent.toLowerCase() || '';
                const category = item.getAttribute('data-category') || '';
                
                if (title.includes(searchTerm) || description.includes(searchTerm) || category.includes(searchTerm)) {
                    item.style.display = 'block';
                    setTimeout(() => {
                        item.style.opacity = '1';
                        item.style.transform = 'scale(1)';
                    }, 10);
                } else {
                    item.style.opacity = '0';
                    item.style.transform = 'scale(0.8)';
                    setTimeout(() => {
                        item.style.display = 'none';
                    }, 300);
                }
            });
            
            // Update filter buttons state
            portfolioFilterButtons.forEach(btn => {
                btn.classList.remove('active');
            });
        });
        
        // Add focus styles
        searchInput.addEventListener('focus', function() {
            this.style.borderColor = 'var(--gold-accent)';
            this.style.boxShadow = '0 0 0 3px rgba(201, 162, 77, 0.1)';
        });
        
        searchInput.addEventListener('blur', function() {
            this.style.borderColor = 'var(--border-color)';
            this.style.boxShadow = 'none';
        });
    }
    
    // Sort functionality for portfolio
    const sortSelect = document.createElement('select');
    sortSelect.className = 'portfolio-sort';
    sortSelect.innerHTML = `
        <option value="default">Sort by: Default</option>
        <option value="date-newest">Date: Newest First</option>
        <option value="date-oldest">Date: Oldest First</option>
        <option value="name-asc">Name: A to Z</option>
        <option value="name-desc">Name: Z to A</option>
    `;
    sortSelect.style.cssText = `
        padding: 10px 15px;
        border: 2px solid var(--border-color);
        border-radius: 30px;
        background: white;
        font-family: var(--font-body);
        margin-left: 20px;
        cursor: pointer;
        transition: all 0.3s ease;
    `;
    
    if (portfolioFilter) {
        portfolioFilter.appendChild(sortSelect);
        
        sortSelect.addEventListener('change', function() {
            const sortValue = this.value;
            const itemsArray = Array.from(portfolioItems);
            
            // Sort based on selected option
            switch (sortValue) {
                case 'date-newest':
                    // Assuming items have data-date attribute
                    itemsArray.sort((a, b) => {
                        const dateA = new Date(a.getAttribute('data-date') || 0);
                        const dateB = new Date(b.getAttribute('data-date') || 0);
                        return dateB - dateA;
                    });
                    break;
                    
                case 'date-oldest':
                    itemsArray.sort((a, b) => {
                        const dateA = new Date(a.getAttribute('data-date') || 0);
                        const dateB = new Date(b.getAttribute('data-date') || 0);
                        return dateA - dateB;
                    });
                    break;
                    
                case 'name-asc':
                    itemsArray.sort((a, b) => {
                        const nameA = a.querySelector('h3')?.textContent || '';
                        const nameB = b.querySelector('h3')?.textContent || '';
                        return nameA.localeCompare(nameB);
                    });
                    break;
                    
                case 'name-desc':
                    itemsArray.sort((a, b) => {
                        const nameA = a.querySelector('h3')?.textContent || '';
                        const nameB = b.querySelector('h3')?.textContent || '';
                        return nameB.localeCompare(nameA);
                    });
                    break;
            }
            
            // Reorder items in DOM
            const container = portfolioItems[0].parentNode;
            itemsArray.forEach(item => {
                container.appendChild(item);
            });
            
            // Reapply current filter
            const activeButton = document.querySelector('.portfolio-filter .filter-btn.active');
            if (activeButton) {
                setTimeout(() => {
                    activeButton.click();
                }, 10);
            }
        });
        
        // Add hover effect to sort select
        sortSelect.addEventListener('mouseenter', function() {
            this.style.borderColor = 'var(--gold-accent)';
        });
        
        sortSelect.addEventListener('mouseleave', function() {
            if (document.activeElement !== this) {
                this.style.borderColor = 'var(--border-color)';
            }
        });
        
        sortSelect.addEventListener('focus', function() {
            this.style.borderColor = 'var(--gold-accent)';
            this.style.boxShadow = '0 0 0 3px rgba(201, 162, 77, 0.1)';
        });
        
        sortSelect.addEventListener('blur', function() {
            this.style.borderColor = 'var(--border-color)';
            this.style.boxShadow = 'none';
        });
    }
    
    // Filter counter
    function updateFilterCounter() {
        const visibleItems = Array.from(portfolioItems).filter(item => 
            item.style.display !== 'none' && item.style.opacity !== '0'
        ).length;
        
        let counter = document.querySelector('.filter-counter');
        if (!counter) {
            counter = document.createElement('div');
            counter.className = 'filter-counter';
            counter.style.cssText = `
                text-align: center;
                margin: 20px 0;
                color: var(--text-secondary);
                font-size: 0.9rem;
            `;
            const filterContainer = document.querySelector('.portfolio-filter');
            if (filterContainer) {
                filterContainer.parentNode.insertBefore(counter, filterContainer.nextSibling);
            }
        }
        
        counter.textContent = `Showing ${visibleItems} of ${portfolioItems.length} items`;
    }
    
    // Update counter on filter changes
    const originalFilterFunction = portfolioFilterButtons[0]?.onclick?.toString();
    portfolioFilterButtons.forEach(button => {
        const originalClick = button.onclick;
        button.onclick = function() {
            if (originalClick) originalClick.call(this);
            setTimeout(updateFilterCounter, 350);
        };
    });
    
    // Initialize counter
    if (portfolioItems.length > 0) {
        setTimeout(updateFilterCounter, 1000);
    }
});