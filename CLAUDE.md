# CLAUDE.md

This file provides guidance to Claude Code (claude.ai/code) when working with code in this repository.

## Commands

```bash
# Start dev environment (API server + queue + Vite)
composer run dev

# Run tests (Pest)
./vendor/bin/pest

# Run a single test file
./vendor/bin/pest tests/Feature/AuthTest.php

# Auto-fix code style (Laravel Pint)
./vendor/bin/pint

# Check style without fixing
./vendor/bin/pint --check

# Database
php artisan migrate
php artisan migrate:fresh --seed
```

## Architecture

This is a personal finance REST API following the **Controller → Service → Repository** pattern.

### Request Flow

`Route → FormRequest (validation) → Controller → Service (business logic) → Repository (data access) → Eloquent Model`

### Directory Layout

- `app/Http/Controllers/` — Thin controllers; delegate all logic to Services
- `app/Services/` — Business rules, domain exceptions, orchestration
- `app/Repositories/` — All Eloquent queries; every method filters by `user_id`
- `app/Http/Requests/` — Input validation with Portuguese error messages
- `app/Http/Resources/` — JSON transformers (currency formatting as R$, dual date formats)
- `app/Exceptions/` — Domain exceptions (e.g. `CategoryInUseException`)
- `app/Mail/` — Mailables for email verification and password reset

### Authentication

- **Sanctum** plain-text tokens (`auth:sanctum` middleware)
- **Two-step access**: auth + custom `verified.email` middleware (blocks unverified users with 403)
- Email verification uses a 6-digit code with a 15-minute expiry stored in `users.email_verification_token`
- Password reset revokes all tokens, forcing re-login

### Data Isolation

Every repository method scopes queries to the authenticated user via `where('user_id', auth()->id())`. There is no multi-tenancy package — just consistent user-scoped queries throughout.

### Domain Model

```
User ──< Transactions >── Categories
```

- `transactions.registerType` is an enum: `'income'` | `'outcome'`
- Deleting a `Category` that has linked transactions throws `CategoryInUseException` (caught in `CategoriesController` → 422)
- `TransactionsResource` adds a `searchable` field (ASCII-normalised concatenation) for client-side search

### Testing

- Pest with `RefreshDatabase` trait (SQLite in-memory via `phpunit.xml`)
- Feature tests use `$this->actingAs($user)` and `Mail::fake()`
- Tests live in `tests/Feature/` (HTTP-level) and `tests/Unit/`

### Environment

- `FRONTEND_URL` — used to build password-reset links in emails
- Database defaults to MySQL; tests override to SQLite in-memory automatically
