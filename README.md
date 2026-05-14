# Domain Check System

Admin panel for automatic domain availability monitoring.

## Overview

Domain Check System is a Laravel-based web application that allows users to monitor the availability of their domains. The application periodically sends HTTP requests to registered domains and records the results — response time, HTTP status code, and errors. If a domain changes its status, the user receives an email notification.

## Features

### Authentication
- User registration and login
- Protected private pages
- Each user manages only their own domains

### Domain Management
- Add, edit, delete domains
- Enable / disable monitoring per domain
- Configure check interval (minutes)
- Configure request timeout (seconds)
- Choose HTTP method: `GET` or `HEAD`

### Monitoring
- Automatic scheduled checks every minute
- Manual domain check from the UI
- Results saved to check history
- Tracks: availability, HTTP status code, response time, error message

### Notifications
- Email notification when domain goes **down**
- Email notification when domain comes back **up**

### UI
- AJAX actions without full page reload
- AJAX pagination
- Toast notifications
- Responsive design

## Tech Stack

| Layer | Technology |
|---|---|
| Backend | PHP 8.3, Laravel 12 |
| Frontend | Blade, Alpine.js, TailwindCSS |
| Database | MySQL 8.0 |
| Environment | Docker, Docker Compose |
| Scheduler | Laravel Scheduler |

---
## Requirements

For Docker setup:

- Docker
- Docker Compose

For local setup without Docker:

- PHP 8.3+
- Composer
- Node.js
- NPM
- MySQL 8+

---

## Installation with Docker

**1. Clone the repository**

```bash
git clone https://gitlab.com/vetal110/domain-check.git
cd domain-check
```

**2. Copy environment file**

```bash
cp .env.example .env
```
The project includes a pre-configured `.env.example` file.

For Docker setup, the default values in `.env.example` are already configured
to work with the Docker Compose services — no changes needed.

**3. Start containers**

```bash
docker compose up -d --build
```

**4. Install dependencies**

```bash
docker compose exec php composer install
docker compose exec php npm install
docker compose exec php npm run build
```

**5. Generate application key**

```bash
docker compose exec php php artisan key:generate
```

**6. Run migrations**

```bash
docker compose exec php php artisan migrate
```

**7. Open in browser**
http://localhost:8080

## Artisan Commands

### Check domains manually

Checks all active domains that are due for a check:

```bash
# Docker
docker compose exec php php artisan domains:check
```

### Clean old check history

Deletes check records older than N days (default: 30):

```bash
docker compose exec php php artisan domain-checks:clean --days=30
```
---

## Scheduled Tasks

Both commands run automatically via Laravel Scheduler inside Docker.

| Command | Schedule     | Description |
|---|--------------|---|
| `domains:check` | Every minute | Check active domains availability |
| `domain-checks:clean --days=30` | Daily        | Delete old check history |


---

## Project Structure

```text
domain-check/
├── app/
│   ├── Console/
│   │   └── Commands/
│   │       ├── CheckDomainsCommand.php
│   │       └── CleanDomainChecksCommand.php
│   ├── Enums/
│   │   ├── DomainCheckMethod.php
│   │   └── DomainStatus.php
│   ├── Models/
│   │   ├── Domain.php
│   │   └── DomainCheck.php
│   ├── Notifications/
│   │   └── DomainStatusChanged.php
│   └── Services/
│       └── DomainCheckService.php
├── dockerfiles/
│   └── php.Dockerfile
├── docker-compose.yml
└── README.md
```

## How It Works

1. User registers and adds domains with check settings
2. Laravel Scheduler runs `domains:check` every minute
3. Command finds all active domains where `next_check_at <= now()`
4. For each domain, `DomainCheckService` sends an HTTP request
5. Result is saved to `domain_checks` table
6. Domain `last_status`, `last_checked_at`, `next_check_at` are updated
7. If status changed — email notification is dispatched to queue
8. Queue worker processes and sends the notification

## Demo

To get started:

1. Open the demo link
2. Click **Register** and create an account
3. After login, click **Add Domain**
4. Enter domain URL and configure check settings
5. Save — monitoring starts automatically
