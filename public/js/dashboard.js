document.addEventListener('DOMContentLoaded', function () {
    // Sidebar Toggle
    const menuToggle = document.getElementById('menu-toggle');
    const closeSidebar = document.getElementById('close-sidebar');
    const sidebar = document.querySelector('.sidebar');
    const overlay = document.createElement('div');

    // Add overlay for mobile
    overlay.className = 'sidebar-overlay';
    document.body.appendChild(overlay);

    function toggleSidebar() {
        sidebar.classList.toggle('active');
        overlay.classList.toggle('active');
    }

    if (menuToggle) {
        menuToggle.addEventListener('click', toggleSidebar);
    }

    if (closeSidebar) {
        closeSidebar.addEventListener('click', toggleSidebar);
    }

    overlay.addEventListener('click', toggleSidebar);

    // Active Link Highlighting
    const currentLocation = location.href;
    const menuItem = document.querySelectorAll('.sidebar-menu a');
    const menuLength = menuItem.length;
    for (let i = 0; i < menuLength; i++) {
        if (menuItem[i].href === currentLocation) {
            menuItem[i].className = "active";
        }
    }

    // Counter Animation
    const counters = document.querySelectorAll('.counter');
    counters.forEach(counter => {
        const updateCount = () => {
            const target = +counter.getAttribute('data-target');
            const count = +counter.innerText;
            const inc = target / 200;

            if (count < target) {
                counter.innerText = Math.ceil(count + inc);
                setTimeout(updateCount, 20);
            } else {
                counter.innerText = target;
            }
        };
        updateCount();
    });

    // Revenue Chart Initialization
    const ctx = document.getElementById('revenueChart');
    if (ctx) {
        const gradient = ctx.getContext('2d').createLinearGradient(0, 0, 0, 400);
        gradient.addColorStop(0, 'rgba(122, 31, 43, 0.5)'); // Maroon
        gradient.addColorStop(1, 'rgba(122, 31, 43, 0)');

        new Chart(ctx, {
            type: 'line',
            data: {
                labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
                datasets: [{
                    label: 'Revenue ($)',
                    data: [5000, 7500, 6000, 9500, 12000, 15500, 11000, 14000, 10500, 13000, 16500, 21000],
                    backgroundColor: gradient,
                    borderColor: '#7a1f2b',
                    borderWidth: 2,
                    pointBackgroundColor: '#c9a24d',
                    pointBorderColor: '#fff',
                    pointHoverBackgroundColor: '#fff',
                    pointHoverBorderColor: '#7a1f2b',
                    fill: true,
                    tension: 0.4
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: { display: false },
                    tooltip: {
                        mode: 'index',
                        intersect: false,
                        backgroundColor: '#2b1b1e',
                        titleColor: '#fdf7f2',
                        bodyColor: '#6b5a5e',
                        borderColor: 'rgba(122, 31, 43, 0.1)',
                        borderWidth: 1,
                        padding: 10,
                        displayColors: false,
                    }
                },
                scales: {
                    x: {
                        grid: {
                            color: 'rgba(255,255,255,0.02)',
                            drawBorder: false
                        },
                        ticks: { color: '#6b5a5e' }
                    },
                    y: {
                        grid: {
                            color: 'rgba(255,255,255,0.02)',
                            drawBorder: false
                        },
                        ticks: {
                            color: '#6b5a5e',
                            callback: function (value) { return '$' + value; }
                        },
                        beginAtZero: true
                    }
                },
                interaction: {
                    mode: 'nearest',
                    axis: 'x',
                    intersect: false
                }
            }
        });
    }
});
