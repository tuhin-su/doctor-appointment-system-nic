# 🚀 Laravel Project Setup & Usage Guide

## 🛠 Installation & Optimization

Run the following commands to install dependencies and optimize autoloading:

```bash
composer install --optimize-autoloader --no-dev
```

Start PHP-FPM (ensure it's running as a background service or system-managed):

```bash
php-fpm
```

## 🔐 Application Key & Database Setup

Generate the application key:

```bash
php artisan key:generate
```

Generate the sessions table (for `database` session driver):

```bash
php artisan session:table
```

Run migrations:

```bash
php artisan migrate
```

## 🧹 Clear Cached Configs, Views, and Cache

```bash
php artisan view:clear
php artisan config:clear
php artisan cache:clear
php artisan livewire:discover
```

## 🌐 Local Development Server

Run the Laravel development server:

```bash
php artisan serve --host=0.0.0.0 --port=8000
```

## 🧵 Queue Worker (for Jobs, Notifications, etc.)

```bash
php artisan queue:work
```

---

## ⚡ Livewire Components

Create a new Livewire component:

```bash
php artisan make:livewire Counter
```

---

## 🧩 Model Generation with Reliese

### 1. Install Required Packages

```bash
composer require doctrine/dbal
composer require reliese/laravel --dev
```

### 2. Publish Reliese Configuration

```bash
php artisan vendor:publish --tag=reliese-models
```

### 3. Generate Models for Specific Tables

```bash
php artisan code:models <TableName>
```

> Replace `<TableName>` with the actual name of your database table.

---

## 👤 User Model Customization

If you're working with authentication, ensure your `User` model extends `Authenticatable`:

```php
namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    // your code here
}
```
