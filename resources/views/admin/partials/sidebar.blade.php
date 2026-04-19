<!-- Sidebar -->
<aside class="sidebar">
    <div class="sidebar-header">
        <div class="brand"><img src="{{ asset('images/logo.png') }}" alt="Snap2Shoot Logo" class="logo-img"></div>
        <div id="close-sidebar" class="menu-toggle">
            <i class="fas fa-times"></i>
        </div>
    </div>

    <ul class="sidebar-menu">

        <li>
            <a href="{{ url('admin/dashboard') }}"
               class="{{ request()->is('admin/dashboard') ? 'active' : '' }}">
                <i class="fas fa-th-large"></i> Dashboard
            </a>
        </li>
        <li>
            <a href="{{ url('admin/team') }}">
                <i class="fas fa-users"></i>
                <span>Team Members</span>
            </a>
        </li>
        <li>
            <a href="{{ url('admin/bookings') }}"
               class="{{ request()->is('admin/bookings') ? 'active' : '' }}">
                <i class="fas fa-calendar-check"></i> Bookings
            </a>
        </li>

        <li>
            <a href="{{ url('admin/portfolio-manage') }}"
               class="{{ request()->is('admin/portfolio-manage') ? 'active' : '' }}">
                <i class="fas fa-images"></i> Portfolio
            </a>
        </li>

        <li>
            <a href="{{ url('admin/services-manage') }}"
               class="{{ request()->is('admin/services-manage') ? 'active' : '' }}">
                <i class="fas fa-camera"></i> Services
            </a>
        </li>

        <li>
            <a href="{{ url('admin/reviews-manage') }}"
               class="{{ request()->is('admin/reviews-manage') ? 'active' : '' }}">
                <i class="fas fa-star"></i> Reviews
            </a>
        </li>

        <li>
            <a href="{{ url('admin/messages') }}"
               class="{{ request()->is('admin/messages') ? 'active' : '' }}">
                <i class="fas fa-envelope"></i> Messages
            </a>
        </li>

        <li>
            <a href="{{ url('admin/reports') }}"
               class="{{ request()->is('admin/reports') ? 'active' : '' }}">
                <i class="fas fa-chart-line"></i> Reports
            </a>
        </li>

        <li>
            <a href="{{ url('admin/settings') }}"
               class="{{ request()->is('admin/settings') ? 'active' : '' }}">
                <i class="fas fa-cog"></i> Settings
            </a>
        </li>

        <li>
            <a href="{{ url('/') }}">
                <i class="fas fa-sign-out-alt"></i> Logout
            </a>
        </li>
    </ul>
</aside>
