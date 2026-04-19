# 📸 Snap2Shoot

> A full-featured **Photography Booking & Portfolio Management Platform** built with Laravel 12.

![Laravel](https://img.shields.io/badge/Laravel-12.x-FF2D20?style=for-the-badge&logo=laravel&logoColor=white)
![PHP](https://img.shields.io/badge/PHP-8.2+-777BB4?style=for-the-badge&logo=php&logoColor=white)
![SQLite](https://img.shields.io/badge/SQLite-Database-003B57?style=for-the-badge&logo=sqlite&logoColor=white)
![Vite](https://img.shields.io/badge/Vite-Frontend-646CFF?style=for-the-badge&logo=vite&logoColor=white)
![License](https://img.shields.io/badge/License-MIT-green?style=for-the-badge)

---

## 📋 Table of Contents

- [About the Project](#-about-the-project)
- [Features](#-features)
- [Tech Stack](#-tech-stack)
- [Project Structure](#-project-structure)
- [Prerequisites](#-prerequisites)
- [Installation](#-installation)
- [Environment Configuration](#-environment-configuration)
- [Running the Application](#-running-the-application)
- [Available Routes](#-available-routes)
- [Admin Panel](#-admin-panel)
- [Database](#-database)
- [Testing](#-testing)
- [Deployment](#-deployment)
- [Contributing](#-contributing)
- [License](#-license)

---

## 🎯 About the Project

**Snap2Shoot** is a modern photography business platform that allows photographers to showcase their work, manage bookings, handle client relationships, and run their business from a single dashboard.

Whether you're a freelance photographer or running a photography studio, Snap2Shoot gives you everything you need — a beautiful public-facing website and a powerful admin panel behind the scenes.

---

## ✨ Features

### 🌐 Public Website
| Feature | Description |
|--------|-------------|
| 🏠 Home Page | Hero section, highlights, and call-to-action |
| ℹ️ About Page | Photographer/studio profile and story |
| 🛠️ Services Page | Display photography packages and pricing |
| 🖼️ Portfolio Page | Showcase of photography work/gallery |
| ⭐ Reviews Page | Client testimonials and ratings |
| 📬 Contact Page | Inquiry/booking form for clients |

### 🔐 Authentication
| Feature | Description |
|--------|-------------|
| Register | New user account creation |
| Login / Logout | Secure session-based authentication |
| Protected Routes | Middleware-protected dashboard |

### 🛠️ Admin Panel
| Module | Description |
|--------|-------------|
| 📊 Dashboard | Overview stats — bookings, clients, revenue |
| 📅 Bookings | View and manage all photography session bookings |
| 👥 Clients | Client list and relationship management |
| 🖼️ Portfolio Management | Add, edit, remove portfolio images |
| 🛠️ Services Management | Manage service packages and pricing |
| ⭐ Reviews Management | Moderate and respond to client reviews |
| 💬 Messages | View client inquiries from the contact form |
| 📈 Reports | Business performance and booking analytics |
| ⚙️ Settings | Studio/photographer settings and preferences |

---

## 🧰 Tech Stack

| Layer | Technology |
|-------|-----------|
| **Backend Framework** | Laravel 12.x |
| **Language** | PHP 8.2+ |
| **Database** | SQLite (default) / MySQL (configurable) |
| **Frontend Build** | Vite |
| **Templating** | Blade (Laravel) |
| **Authentication** | Laravel built-in Auth |
| **Queue** | Database queue driver |
| **Cache** | Database cache driver |
| **Session** | Database session driver |
| **Testing** | PHPUnit 11 |
| **Code Style** | Laravel Pint |
| **Dev Tools** | Laravel Pail (log viewer), Laravel Sail |

---

## 📁 Project Structure

```
snap2shoot/
├── app/
│   ├── Http/
│   │   └── Controllers/
│   │       ├── Admin/              # Admin panel controllers
│   │       │   ├── BookingController.php
│   │       │   ├── ClientController.php
│   │       │   ├── DashboardController.php
│   │       │   ├── MessageController.php
│   │       │   ├── PortfolioController.php
│   │       │   ├── ReportController.php
│   │       │   ├── ReviewController.php
│   │       │   ├── ServiceController.php
│   │       │   └── SettingController.php
│   │       ├── AuthController.php  # Login / Register / Logout
│   │       └── HomeController.php  # Public pages
│   ├── Models/
│   │   └── User.php
│   └── Providers/
│       └── AppServiceProvider.php
├── database/
│   ├── migrations/                 # Database table definitions
│   ├── factories/                  # Test data factories
│   └── seeders/                    # Database seeders
├── resources/
│   └── views/
│       ├── admin/                  # Admin panel Blade views
│       ├── auth/                   # Login & Register views
│       ├── layouts/                # Shared layout templates
│       ├── index.blade.php         # Home page
│       ├── about.blade.php
│       ├── services.blade.php
│       ├── portfolio.blade.php
│       ├── reviews.blade.php
│       └── contact.blade.php
├── routes/
│   └── web.php                     # All application routes
├── config/                         # Laravel config files
├── public/                         # Web root (index.php, assets)
├── storage/                        # Logs, cache, uploaded files
├── .env.example                    # Environment template
├── composer.json                   # PHP dependencies
└── package.json                    # Node dependencies
```

---

## ✅ Prerequisites

Make sure you have the following installed on your machine:

- **PHP** >= 8.2
- **Composer** >= 2.x → [Install Composer](https://getcomposer.org/)
- **Node.js** >= 18.x & **npm** → [Install Node.js](https://nodejs.org/)
- **Git** → [Install Git](https://git-scm.com/)
- **SQLite** (usually bundled with PHP) — or **MySQL** if you prefer

To check your versions:
```bash
php -v
composer -V
node -v
npm -v
```

---

## 🚀 Installation

### 1. Clone the Repository

```bash
git clone https://github.com/yourusername/snap2shoot.git
cd snap2shoot
```

### 2. Install PHP Dependencies

```bash
composer install
```

### 3. Install Node Dependencies

```bash
npm install
```

### 4. Set Up Environment File

```bash
cp .env.example .env
```

### 5. Generate Application Key

```bash
php artisan key:generate
```

### 6. Run Database Migrations

```bash
php artisan migrate
```

### 7. (Optional) Seed the Database

```bash
php artisan db:seed
```

### 8. Build Frontend Assets

```bash
npm run build
```

> **Tip:** You can also run the full setup in one command (uses the `setup` script in `composer.json`):
> ```bash
> composer run setup
> ```

---

## ⚙️ Environment Configuration

Copy `.env.example` to `.env` and update the following key variables:

```env
# Application
APP_NAME=Snap2Shoot
APP_ENV=local
APP_URL=http://localhost

# Database (SQLite - default, no extra setup needed)
DB_CONNECTION=sqlite

# OR switch to MySQL:
# DB_CONNECTION=mysql
# DB_HOST=127.0.0.1
# DB_PORT=3306
# DB_DATABASE=snap2shoot
# DB_USERNAME=root
# DB_PASSWORD=your_password

# Mail (for contact form notifications)
MAIL_MAILER=smtp
MAIL_HOST=smtp.mailtrap.io
MAIL_PORT=2525
MAIL_USERNAME=your_username
MAIL_PASSWORD=your_password
MAIL_FROM_ADDRESS="hello@snap2shoot.com"
MAIL_FROM_NAME="Snap2Shoot"
```

> ⚠️ **Never commit your `.env` file.** It contains sensitive keys and is already listed in `.gitignore`.

---

## ▶️ Running the Application

### Development Mode (all services at once)

```bash
composer run dev
```

This starts:
- `php artisan serve` → Laravel server at `http://localhost:8000`
- `npm run dev` → Vite hot-reload
- `php artisan queue:listen` → Background job processing
- `php artisan pail` → Real-time log viewer

### Or start manually:

```bash
# Terminal 1 - Laravel server
php artisan serve

# Terminal 2 - Vite (frontend hot reload)
npm run dev
```

Then open your browser at: **http://localhost:8000**

---

## 🗺️ Available Routes

### Public Routes

| Method | URL | Description |
|--------|-----|-------------|
| GET | `/` | Home page |
| GET | `/about` | About page |
| GET | `/services` | Services page |
| GET | `/portfolio` | Portfolio gallery |
| GET | `/reviews` | Client reviews |
| GET | `/contact` | Contact / booking form |

### Auth Routes

| Method | URL | Description |
|--------|-----|-------------|
| GET | `/register` | Registration form |
| POST | `/register` | Submit registration |
| GET | `/login` | Login form |
| POST | `/login` | Submit login |
| GET | `/logout` | Logout user |
| GET | `/dashboard` | User dashboard (auth required) |

### Admin Routes

| Method | URL | Description |
|--------|-----|-------------|
| GET | `/admin/dashboard` | Admin overview |
| GET | `/admin/bookings` | Manage bookings |
| GET | `/admin/clients` | Manage clients |
| GET | `/admin/portfolio-manage` | Manage portfolio |
| GET | `/admin/services-manage` | Manage services |
| GET | `/admin/reviews-manage` | Manage reviews |
| GET | `/admin/messages` | View messages |
| GET | `/admin/reports` | View reports |
| GET | `/admin/settings` | App settings |

---

## 🛠️ Admin Panel

Access the admin panel at: **http://localhost:8000/admin/dashboard**

The admin panel includes:
- **Dashboard** with key business metrics
- **Booking management** — view all client session bookings
- **Client management** — full client directory
- **Portfolio management** — upload and manage photos
- **Service management** — add/edit photography packages
- **Review moderation** — manage client testimonials
- **Inbox** — read messages from the contact form
- **Reports** — business performance analytics
- **Settings** — configure studio details

---

## 🗄️ Database

By default, the app uses **SQLite** — no server setup required.

The SQLite file is located at:
```
database/database.sqlite
```

> ⚠️ This file is excluded from version control via `.gitignore`. Each developer creates their own local database via migrations.

**To switch to MySQL**, update your `.env`:
```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=snap2shoot
DB_USERNAME=root
DB_PASSWORD=
```

Then run:
```bash
php artisan migrate
```

---

## 🧪 Testing

This project uses **PHPUnit** for automated testing.

```bash
# Run all tests
composer run test

# Or directly
php artisan test

# Run specific test file
php artisan test --filter ExampleTest
```

---

## 🌐 Deployment

### Production Checklist

```bash
# 1. Set environment to production
APP_ENV=production
APP_DEBUG=false

# 2. Install production dependencies only
composer install --optimize-autoloader --no-dev

# 3. Build frontend assets for production
npm run build

# 4. Cache config, routes, and views for performance
php artisan config:cache
php artisan route:cache
php artisan view:cache

# 5. Run migrations on the production DB
php artisan migrate --force
```

### Recommended Hosting Platforms
- [Laravel Forge](https://forge.laravel.com/) + DigitalOcean / AWS / Vultr
- [Railway](https://railway.app/)
- [Render](https://render.com/)
- [Shared hosting with cPanel + PHP 8.2]

---

## 🤝 Contributing

Contributions are welcome! Here's how to get started:

1. Fork the repository
2. Create a feature branch: `git checkout -b feature/your-feature-name`
3. Make your changes and commit: `git commit -m "Add: your feature description"`
4. Push to your branch: `git push origin feature/your-feature-name`
5. Open a **Pull Request**

Please follow [PSR-12](https://www.php-fig.org/psr/psr-12/) coding standards. Run code style fixes with:
```bash
./vendor/bin/pint
```

---

## 📄 License

This project is licensed under the **MIT License** — see the [LICENSE](LICENSE) file for details.

---

## 👤 Author

**Your Name**
- GitHub: [@yourusername](https://github.com/yourusername)
- Email: your.email@example.com

---

<p align="center">Made with ❤️ using Laravel</p>
