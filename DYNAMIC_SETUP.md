# Snap2Shoot — Dynamic Setup Guide

This project has been fully converted from a static site to a dynamic Laravel application.

## What's Now Dynamic

### Database Tables Created
| Table | Description |
|-------|-------------|
| `services` | Photography packages with features, pricing, icon |
| `portfolio_items` | Portfolio images with category, featured flag |
| `reviews` | Client testimonials with approval workflow |
| `bookings` | Client bookings with service, date, status |
| `messages` | Contact form submissions |
| `team_members` | Team profiles for About page |
| `settings` | All site content (hero text, contact info, etc.) |

### Frontend Pages — All Dynamic
- **Home** (`/`) — Services, portfolio, reviews, hero content from DB
- **About** (`/about`) — Team members and story from DB
- **Services** (`/services`) — Packages and features from DB
- **Portfolio** (`/portfolio`) — Items with category filter from DB
- **Reviews** (`/reviews`) — Approved reviews with live rating stats
- **Contact** (`/contact`) — Form saves to `messages` table, services dropdown from DB

### Admin Panel — All Functional CRUD
- **Dashboard** (`/admin/dashboard`) — Live stats, upcoming bookings, revenue chart
- **Bookings** (`/admin/bookings`) — Create, update status, delete bookings
- **Clients** (`/admin/clients`) — Auto-derived from bookings with spend tracking
- **Portfolio** (`/admin/portfolio-manage`) — Add/delete portfolio items
- **Services** (`/admin/services-manage`) — Full CRUD with modal editor
- **Reviews** (`/admin/reviews-manage`) — Approve / Reject / Delete reviews
- **Messages** (`/admin/messages`) — Read/delete contact enquiries
- **Reports** (`/admin/reports`) — Revenue charts, monthly breakdown
- **Settings** (`/admin/settings`) — Edit ALL site content from one page

## Setup Steps

```bash
# 1. Install dependencies
composer install

# 2. Copy .env and configure DB
cp .env.example .env
php artisan key:generate

# 3. Configure .env for your database (SQLite works out of the box)
# DB_CONNECTION=sqlite
# DB_DATABASE=/absolute/path/to/database/database.sqlite

# 4. Run migrations + seed (creates all tables + sample data)
php artisan migrate --seed

# 5. Admin login
# Email: admin@snap2shoot.com
# Password: admin123

# 6. Start server
php artisan serve
```

## Admin Credentials (after seeding)
- **Email:** admin@snap2shoot.com  
- **Password:** admin123
