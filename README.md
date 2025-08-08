
# Creamsy POS System

A modern Point of Sale (POS) system built with Laravel and Livewire, featuring a clean, responsive interface and powerful inventory management.

## ✨ Features

- 🛍️ **Point of Sale (POS) System**
  - Fast product search and cart management
  - Discount and promotion handling
  - Receipt generation and printing

- 👥 **User Management**
  - Role-based access control
  - Activity logging
  - User profile management

- 📦 **Inventory Management**
  - Product catalog with categories
  - Stock tracking
  - Product variants (cones, cups, toppings)

- 📊 **Reporting**
  - Sales analytics
  - Transaction history
  - Revenue tracking

- 🌐 **Modern UI/UX**
  - Dark/Light mode
  - Responsive design
  - Intuitive interface

## 🖥️ Screenshots

| Public Interface | POS Interface |
|--------------|-------------------|
| ![Public Interface](/docs/docs%20(1).png) | ![POS Interface](/docs/docs%20(6).png) |

| Receipt | Manager & Admin Interface |
|--------------|----------|
| ![Receipt](/docs/docs%20(5).png) | ![Receipt](/docs/docs%20(4).png) |

| Product Management | Admin Features |
|--------------|----------|
| ![Receipt](/docs/docs%20(3).png) | ![Receipt](/docs/docs%20(2).png) |

## 🛠️ Tech Stack

Built with the TALL stack:
- [Tailwind CSS](https://tailwindcss.com) - Utility-first CSS framework
- [Alpine.js](https://alpinejs.dev) - Minimal framework for JavaScript behavior
- [Laravel](https://laravel.com) - Robust PHP framework
- [Livewire](https://livewire.laravel.com) - Full-stack framework for Laravel
-   [Laravel](https://laravel.com)
-   [Laravel Livewire](https://livewire.laravel.com) using the components.

## Further it includes:
Among other things, it also includes:
-   [Flux UI](https://fluxui.dev) for flexible UI components (free version)
-   [Laravel Pint](https://github.com/laravel/pint) for code style fixes
-   [PestPHP](https://pestphp.com) for testing
-   [missing-livewire-assertions](https://github.com/christophrumpel/missing-livewire-assertions) for extra testing of Livewire components by [Christoph Rumpel](https://github.com/christophrumpel)
-   [LivewireAlerts](https://github.com/jantinnerezo/livewire-alert) for SweetAlerts
-   [Spatie Roles & Permissions](https://spatie.be/docs/laravel-permission/v5/introduction) for user roles and permissions
-   [Strict Eloquent Models](https://planetscale.com/blog/laravels-safety-mechanisms) for safety
-   [Laravel Debugbar](https://github.com/barryvdh/laravel-debugbar) for debugging
-   [Laravel IDE helper](https://github.com/barryvdh/laravel-ide-helper) for IDE support

## Upcoming features
I'm considering adding the following features, depending on my clients' most common requirements:
-   [Wire Elements / Modals](https://github.com/wire-elements/modal) for modals (still deciding - for now I'm using Flux UI for this)
-   [Laravel Cashier](https://laravel.com/docs/10.x/billing) for Stripe integration

## 🚀 Installation

### Prerequisites
- PHP 8.2 or higher
- Composer
- Node.js & NPM
- MySQL/PostgreSQL/SQLite
- Git

### Quick Start

1. **Clone the repository**
   ```bash
   git clone https://github.com/yourusername/creamsy-pos.git
   cd creasmy-pos
   ```

2. **Install PHP dependencies**
   ```bash
   composer install
   ```

3. **Install NPM dependencies**
   ```bash
   npm install
   ```

4. **Setup environment**
   ```bash
   cp .env.example .env
   php artisan key:generate
   ```

5. **Configure database**
   Update your `.env` file with your database credentials:
   ```env
   DB_CONNECTION=mysql
   DB_HOST=127.0.0.1
   DB_PORT=3306
   DB_DATABASE=creamsy_pos
   DB_USERNAME=your_username
   DB_PASSWORD=your_password
   ```

6. **Run migrations & seed database**
   ```bash
   php artisan migrate --seed
   ```

7. **Create storage link**
   ```bash
   php artisan storage:link
   ```

8. **Compile assets**
   ```bash
   npm run build
   # or for development:
   # npm run dev
   ```

9. **Create admin user**
   ```bash
   php artisan app:create-super-admin
   ```

10. **Start the development server**
    ```bash
    php artisan serve
    ```

    Visit `http://127.0.0.1:8000` in your browser.

### Default Login Credentials
- **Email:** admin@creamsy.test
- **Password:** password

> 💡 For production, make sure to update these credentials after first login.
php artisan make:manager manager manager@email password
php artisan make:cashier manager cashier@email password


6. Set default timezone if different from UTC
// config/app.php
return [
    // ...

    'timezone' => 'Europe/Copenhagen' // Default: UTC

    // ...
];