# AGENTS.md

## Stack

Laravel 12, PHP 8.2+, SQLite, Tailwind CSS v4, Vite 6, Laravel Pint.

## Setup

- **DB**: SQLite via `database/database.sqlite` (already exists).
- **Env**: `.env` is present with `APP_KEY` set. Uses SQLite, database-backed sessions/cache/queue.
- `.env.example` — copy to `.env`, run `php artisan key:generate` if starting fresh.

## Commands

| Action | Command |
|--------|---------|
| Dev server (all-in-1) | `composer dev` |
| Build assets | `npm run build` |
| Lint (Pint) | `./vendor/bin/pint` |
| Run tests | `php artisan test` or `./vendor/bin/phpunit` |
| Run tests (filter) | `php artisan test --filter=ExampleTest` |
| Run migrations | `php artisan migrate` |
| Tinker (REPL) | `php artisan tinker` |

`composer dev` runs 4 processes concurrently: `php artisan serve`, `php artisan queue:listen --tries=1`, `php artisan pail --timeout=0`, `npm run dev`.

## Code style

- **Indent**: 4 spaces, LF line endings (`.editorconfig`).
- **PSR-4**: `App\` → `app/`, `Database\Factories\` → `database/factories/`, `Database\Seeders\` → `database/seeders/`, `Tests\` → `tests/`.
- **Linter**: Laravel Pint (`./vendor/bin/pint`) — run before committing.

## Architecture

- **Entrypoint**: `public/index.php` → `bootstrap/app.php`.
- **Routes**: `routes/web.php` (web), `routes/console.php` (Artisan commands).
- **Views**: Blade in `resources/views/`, entry CSS/JS in `resources/css/app.css`, `resources/js/app.js`.
- **Frontend**: Tailwind v4 via `@tailwindcss/vite` plugin, Vite with `laravel-vite-plugin`.
- **Session/Cache/Queue**: All use database driver (SQLite). Requires `php artisan queue:table` + `php artisan migrate` for queue.

## Testing

- PHPUnit with `tests/Unit/` and `tests/Feature/` suites.
- Extend `Tests\TestCase` (wraps `Illuminate\Foundation\Testing\TestCase`).
- Test env overrides: `CACHE_STORE=array`, `SESSION_DRIVER=array`, `QUEUE_CONNECTION=sync`, `DB_CONNECTION=sqlite` (commented out — uses default).
