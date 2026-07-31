# Student Portal Login and Registration System

A secure Laravel 12 + PHP 8 project that demonstrates:

- user registration and login using sessions
- a protected dashboard for CRUD profile management
- PDO prepared statements for database access
- Tailwind CSS interface
- CSRF protection, password hashing, XSS-safe output, and session timeout handling

## Features

1. Custom session authentication
2. Secure registration with `password_hash()` and login with `password_verify()`
3. Protected dashboard available only to logged-in users
4. Full CRUD for profile records
5. PDO prepared statements for `users` and `profiles` queries
6. Client-side and server-side validation
7. Friendly error handling and flash messages
8. Session timeout tracking with invalidation on inactivity
9. CSRF protection via Laravel form tokens

## Tech Stack

- PHP 8.2
- Laravel 12
- SQLite for local demo setup
- Tailwind CSS 4

## Database Tables

- `users`
- `password_reset_tokens`
- `sessions`
- `profiles`

The SQL structure is available in `database/schema.sql`.

## Setup Instructions

1. Install PHP 8.2+, Composer, and Node.js.
2. Clone or open the project folder.
3. Install dependencies:

```bash
composer install
npm install
```

4. Copy environment file if needed:

```bash
copy .env.example .env
```

5. Generate the application key:

```bash
php artisan key:generate
```

6. Make sure `database/database.sqlite` exists, then run migrations:

```bash
php artisan migrate
```

7. Start the development servers:

```bash
php artisan serve
npm run dev
```

8. Open `http://127.0.0.1:8000`.

## Test Command

```bash
php artisan test
```

## Security Notes

- Passwords are hashed before storage.
- Login and registration use POST requests.
- Dashboard routes are protected with middleware.
- Session timeout is enforced using a `last_activity` session value.
- Session cookies are configured for encryption and secure cookies in production.
- Blade output escaping helps prevent XSS.
- PDO prepared statements help prevent SQL injection.

## Important Files

- `app/Http/Controllers/AuthController.php`
- `app/Http/Controllers/DashboardController.php`
- `app/Http/Controllers/ProfileController.php`
- `app/Repositories/UserRepository.php`
- `app/Repositories/ProfileRepository.php`
- `app/Http/Middleware/EnsureAuthenticated.php`
- `app/Http/Middleware/EnforceSessionTimeout.php`
- `database/migrations/2026_07_31_101500_create_profiles_table.php`
- `database/schema.sql`

## GitHub Delivery

To publish this repository to your public GitHub account, initialize Git if needed, commit the project, and push it to a public repository. If GitHub CLI is authenticated on your machine, you can use:

```bash
git init
git add .
git commit -m "Build secure Laravel student portal"
gh repo create student-portal-login-crud --public --source=. --push
```

Adjust the repository name if you want a different one.
