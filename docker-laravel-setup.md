# Laravel Docker Setup Guide

This guide outlines how to set up a Laravel project with Docker using PostgreSQL and Mailhog.

---

## ⚙️ Environment Configuration

Below is a sample `.env` configuration for your Laravel application inside Docker:

```env
APP_NAME=Laravel
APP_ENV=local
APP_KEY=base64:MDZj6xz1YEoYcdwc9zPK7Mfm71PlSE8ikIbkj7bFvA0=
APP_DEBUG=true
APP_URL=http://localhost

APP_LOCALE=en
APP_FALLBACK_LOCALE=en
APP_FAKER_LOCALE=en_US

APP_MAINTENANCE_DRIVER=file
# APP_MAINTENANCE_STORE=database

PHP_CLI_SERVER_WORKERS=4

BCRYPT_ROUNDS=12

LOG_CHANNEL=stack
LOG_STACK=single
LOG_DEPRECATIONS_CHANNEL=null
LOG_LEVEL=debug

DB_CONNECTION=pgsql
DB_HOST=db
DB_PORT=5432
DB_DATABASE=test
DB_USERNAME=test
DB_PASSWORD=test1234

SESSION_DRIVER=database
SESSION_LIFETIME=120
SESSION_ENCRYPT=false
SESSION_PATH=/
SESSION_DOMAIN=null

BROADCAST_CONNECTION=reverb
FILESYSTEM_DISK=local
QUEUE_CONNECTION=database

CACHE_STORE=database
# CACHE_PREFIX=

MEMCACHED_HOST=127.0.0.1

REDIS_CLIENT=phpredis
REDIS_HOST=127.0.0.1
REDIS_PASSWORD=null
REDIS_PORT=6379

MAIL_MAILER=smtp
MAIL_HOST=mailhog
MAIL_PORT=1025
MAIL_USERNAME=null
MAIL_PASSWORD=null
MAIL_FROM_ADDRESS="noreply@yourapp.test"
MAIL_FROM_NAME="${APP_NAME}"

AWS_ACCESS_KEY_ID=
AWS_SECRET_ACCESS_KEY=
AWS_DEFAULT_REGION=us-east-1
AWS_BUCKET=
AWS_USE_PATH_STYLE_ENDPOINT=false

VITE_APP_NAME="${APP_NAME}"

PUSHER_APP_ID=1992133
PUSHER_APP_KEY=106c93683dfac93e83f7
PUSHER_APP_SECRET=afbbc2e6d76ff4718421
PUSHER_APP_CLUSTER=mt1 

CACHE_DRIVER=file
```

---

## 🐳 Docker Setup Instructions

1. **Copy the `.env.bkp` to `.env` inside the `src` folder:**

    ```bash
    cp src/.env.bkp src/.env
    ```

2. **Build Docker Containers:**

    ```bash
    docker compose build
    ```

3. **Start Containers:**

    ```bash
    docker compose up -d
    ```

4. **Install Composer Dependencies:**

    ```bash
    docker compose exec app composer install
    ```

5. **Generate Laravel Application Key:**

    ```bash
    docker compose exec app php artisan key:generate
    ```

6. **Run Database Migrations:**

    ```bash
    docker compose exec app php artisan migrate
    ```

---

## 📝 Notes

- PostgreSQL is used as the default database.
- Mailhog is configured for local mail testing on port `1025`.
- Broadcasting is configured to use Laravel Reverb.
- Redis and Memcached are included but optional.
