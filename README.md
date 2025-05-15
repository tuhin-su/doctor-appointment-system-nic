# Laravel Docker Development Environment

This project uses Docker to run a Laravel application for local development.

## 🚀 Quick Start

### 1. Clone the Repository

```bash
git clone https://github.com/tuhin-su/doctor-appointment-system-nic.git
cd doctor-appointment-system-nic
```

### 2. Copy Environment File

Navigate to the `src` folder (where the Laravel project is located) and copy the example environment file:

```bash
cp src/.env.bkp src/.env
```

### 3. Build Docker Containers

```bash
docker compose build
```

### 4. Start the Containers

```bash
docker compose up -d
```

### 5. Install Laravel Dependencies

Once containers are running, access the app container and install PHP dependencies:

```bash
docker compose exec app composer install
```

### 6. Generate Application Key

```bash
docker compose exec app php artisan key:generate
```

### 7. Run Migrations (if needed)

```bash
docker compose exec app php artisan migrate
```

---

## 📁 Project Structure

```
.
├── docker-compose.yml
├── src/               # Laravel project directory
│   ├── .env.bkp
│   ├── .env           # Will be created after copying
│   └── ...
```

---

## 🐳 Notes

- Ensure Docker and Docker Compose are installed on your system.
- The Laravel application is located in the `src/` directory.
- Use `docker compose logs` to view container logs.
- Use `docker compose down` to stop and remove containers.

---

## 🧪 Development Commands

- Run Artisan commands:
  ```bash
  docker compose exec app php artisan <command>
  ```
- Run PHPUnit tests:
  ```bash
  docker compose exec app php artisan test
  ```

---

Happy coding! 🎉
