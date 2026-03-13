# Clinic API

A RESTful API for managing medical clinic bookings, built with Laravel 12, MySQL, Redis and Docker.

This project was built as a portfolio piece to demonstrate proficiency in modern Laravel development, including API authentication, resource transformation, job queues, event-driven architecture, and automated testing.

---

## Tech Stack

- **PHP 8.3** + **Laravel 12**
- **MySQL 8.0** — relational database
- **Redis** — queue driver for async jobs
- **Docker** + **Nginx** — containerized environment
- **Laravel Sanctum** — token-based API authentication

---

## Features

- Token-based authentication (register, login, logout)
- Doctor and service management
- Slot availability management
- Booking system with conflict prevention (unique constraint per slot)
- Async email notifications via job queues
- Event-driven architecture with Laravel Events & Listeners
- Full test coverage with PHPUnit
- API versioning (v1)

---

## Data Model

```
users ──────────────────────────────┐
                                    │
doctors ──┐                         │
          ├──► slots ──────────────► bookings
services ─┘     (doctor_id,          (slot_id,
                 service_id,          user_id,
                 starts_at,           status,
                 ends_at,             notes)
                 is_available)
```

---

## Getting Started

### Requirements

- Docker
- Docker Compose

### Installation

**1. Clone the repository**
```bash
git clone git@github.com:nicola-simioni/clinic-api.git
cd clinic-api
```

**2. Copy the environment file**
```bash
cp .env.example .env
```

**3. Start the containers**
```bash
docker compose up -d --build
```

**4. Install dependencies**
```bash
docker compose exec app composer install
```

**5. Generate application key**
```bash
docker compose exec app php artisan key:generate
```

**6. Run migrations**
```bash
docker compose exec app php artisan migrate
```

The API will be available at: `http://localhost:8000`

---

## API Endpoints

All endpoints are prefixed with `/api/v1`.  
Protected routes require the header: `Authorization: Bearer <token>`

### Authentication

| Method | Endpoint | Auth | Description |
|--------|----------|------|-------------|
| POST | `/register` | No | Register a new user |
| POST | `/login` | No | Login and receive a token |
| POST | `/logout` | Yes | Invalidate current token |
| GET | `/me` | Yes | Get authenticated user |

### Doctors

| Method | Endpoint | Auth | Description |
|--------|----------|------|-------------|
| GET | `/doctors` | Yes | List all active doctors |
| POST | `/doctors` | Yes | Create a new doctor |
| GET | `/doctors/{id}` | Yes | Get a doctor |
| PUT | `/doctors/{id}` | Yes | Update a doctor |
| DELETE | `/doctors/{id}` | Yes | Delete a doctor |

### Services

| Method | Endpoint | Auth | Description |
|--------|----------|------|-------------|
| GET | `/services` | Yes | List all active services |
| POST | `/services` | Yes | Create a new service |
| GET | `/services/{id}` | Yes | Get a service |
| PUT | `/services/{id}` | Yes | Update a service |
| DELETE | `/services/{id}` | Yes | Delete a service |

### Slots

| Method | Endpoint | Auth | Description |
|--------|----------|------|-------------|
| GET | `/slots` | Yes | List available slots |
| POST | `/slots` | Yes | Create a new slot |
| GET | `/slots/{id}` | Yes | Get a slot |
| PUT | `/slots/{id}` | Yes | Update a slot |
| DELETE | `/slots/{id}` | Yes | Delete a slot |

### Bookings

| Method | Endpoint | Auth | Description |
|--------|----------|------|-------------|
| GET | `/bookings` | Yes | List user's bookings |
| POST | `/bookings` | Yes | Create a booking |
| GET | `/bookings/{id}` | Yes | Get a booking |
| DELETE | `/bookings/{id}` | Yes | Cancel a booking |

---

## Running Tests

```bash
docker compose exec app php artisan test
```

---

## Author

**Nicola Simioni**  
[github.com/nicola-simioni](https://github.com/nicola-simioni)
