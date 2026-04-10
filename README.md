# Finance API

A RESTful API for personal finance management — handles authentication, transactions, categories, and financial reports.

---

## Tech Stack

| Layer | Technology |
|---|---|
| Language | PHP ^8.2 |
| Framework | Laravel ^11.0 |
| Authentication | Laravel Sanctum ^4.0 |
| HTTP Client | Guzzle ^7.2 |
| Testing | Pest ^2.0 |
| Code Style | Laravel Pint ^1.0 |
| Dev Environment | Laravel Sail ^1.26 |

---

## Architecture

The project follows a layered **Controller → Service → Repository** pattern:

- **Controllers** — Receive HTTP requests, delegate to Services, return API Resources or JSON responses. No business logic.
- **Services** — Contain all business logic (e.g., computing report totals, enforcing ownership). Depend on Repositories for data access.
- **Repositories** — Encapsulate all Eloquent queries. The single point of database interaction per domain.
- **Form Requests** — Handle input validation and authorization before the request reaches the controller.
- **API Resources** — Transform Eloquent models into consistent, typed JSON responses.
- **Custom Exceptions** — Domain-specific exceptions (e.g., `CategoryInUseException`) provide clean error handling separate from business logic.

---

## Project Structure

```
app/
├── Exceptions/         # Custom domain exceptions and global exception handler
├── Http/
│   ├── Controllers/    # Route handlers — thin layer, delegates to Services
│   │   └── Auth/       # Login and Register controllers
│   ├── Middleware/     # HTTP middleware (e.g., authentication guards)
│   ├── Requests/       # Form Request classes for input validation
│   └── Resources/      # API Resource classes for JSON response transformation
├── Models/             # Eloquent models (User, Transactions, Categories)
├── Providers/          # Service providers for dependency binding
├── Repositories/       # Database query encapsulation per domain
└── Services/           # Business logic layer
```

---

## API Endpoints

### Auth

| Method | Endpoint | Description | Auth Required |
|---|---|---|---|
| `POST` | `/api/login` | Authenticate and receive a Sanctum token | No |
| `POST` | `/api/register` | Create a new user account | No |
| `POST` | `/api/logout` | Revoke all tokens for the authenticated user | Yes |
| `GET` | `/api/me` | Return the currently authenticated user | Yes |

### Profile

| Method | Endpoint | Description | Auth Required |
|---|---|---|---|
| `PUT` | `/api/profile/info` | Update name and email | Yes |
| `PUT` | `/api/profile/password` | Update password | Yes |

### Categories

| Method | Endpoint | Description | Auth Required |
|---|---|---|---|
| `GET` | `/api/categories` | List all categories | Yes |
| `GET` | `/api/categories/{id}` | Get a single category | Yes |
| `POST` | `/api/categories` | Create a category | Yes |
| `PUT` | `/api/categories/{id}` | Update a category | Yes |
| `DELETE` | `/api/categories/{id}` | Delete a category | Yes |

### Transactions

| Method | Endpoint | Description | Auth Required |
|---|---|---|---|
| `GET` | `/api/transactions` | List all transactions for the user | Yes |
| `GET` | `/api/transactions/{id}` | Get a single transaction | Yes |
| `POST` | `/api/transactions` | Create a transaction | Yes |
| `PUT` | `/api/transactions/{id}` | Update a transaction | Yes |
| `DELETE` | `/api/transactions/{id}` | Delete a transaction | Yes |

### Reports

| Method | Endpoint | Description | Auth Required |
|---|---|---|---|
| `GET` | `/api/report` | Get filtered transactions with income/outcome totals | Yes |

---

## Local Setup

### 1. Clone the repository

```bash
git clone https://github.com/wallyson03jhonatan/finance-api.git
cd finance-api
```

### 2. Install dependencies

```bash
composer install
```

### 3. Configure environment

```bash
cp .env.example .env
php artisan key:generate
```

Edit `.env` and set your database and mail credentials (see [Environment Variables](#environment-variables) below).

### 4. Run migrations

```bash
php artisan migrate
```

### 5. Start the development server

```bash
php artisan serve
```

The API will be available at `http://localhost:8000`.

---

## Environment Variables

| Variable | Purpose | Example |
|---|---|---|
| `APP_NAME` | Application name used in responses and mail | `Finance API` |
| `APP_ENV` | Environment context | `local` |
| `APP_KEY` | Encryption key (generated via `artisan key:generate`) | `base64:...` |
| `APP_URL` | Base application URL | `http://localhost` |
| `DB_CONNECTION` | Database driver | `mysql` |
| `DB_HOST` | Database host | `127.0.0.1` |
| `DB_PORT` | Database port | `3306` |
| `DB_DATABASE` | Database name | `finance` |
| `DB_USERNAME` | Database user | `root` |
| `DB_PASSWORD` | Database password | `secret` |
| `MAIL_MAILER` | Mail transport driver | `smtp` |
| `MAIL_HOST` | SMTP server host | `smtp.mailtrap.io` |
| `MAIL_PORT` | SMTP server port | `2525` |
| `MAIL_USERNAME` | SMTP credentials — username | `your_username` |
| `MAIL_PASSWORD` | SMTP credentials — password | `your_password` |
| `MAIL_FROM_ADDRESS` | Default sender address | `noreply@finance.app` |
| `MAIL_FROM_NAME` | Default sender name | `Finance API` |
