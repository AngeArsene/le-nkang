# Le Nkang

18+ escort-listings directory for Cameroon — currently a Laravel 13 / PHP 8.4 scaffold using Blade, Tailwind CSS v4, and Vite.

## What the app does

Le Nkang is intended to be an adults-only listings directory, but the current application only serves an empty Blade view at `/`. It does not yet provide listing browsing, registration, profile or listing management, comments, or authentication; there are no ownership-sensitive actions, custom middleware aliases, or policies in place.

## Features

- [`routes/web.php`](routes/web.php) defines only the named `home` route (`/`); [`bootstrap/app.php`](bootstrap/app.php) registers console routes and Laravel's `/up` health endpoint and renders JSON exceptions for `api/*` and requests expecting JSON.
- [`App\Models\User`](app/Models/User.php) uses Laravel's fillable/hidden attributes and hashes the password via its `hashed` cast. [`DatabaseSeeder`](database/seeders/DatabaseSeeder.php) seeds `Test User` (`test@example.com`); [`UserFactory`](database/factories/UserFactory.php) supplies the hashed default password `password`. There is no password validation rule, auth flow, or `DEFAULT_USER_*` configuration.
- The [`user migration`](database/migrations/0001_01_01_000000_create_users_table.php) creates users with a unique email and nullable `email_verified_at`, plus password-reset-token and database-session tables. The [`cache migration`](database/migrations/0001_01_01_000001_create_cache_table.php) creates cache and cache-lock tables; the [`jobs migration`](database/migrations/0001_01_01_000002_create_jobs_table.php) creates jobs, batches, and failed-job tables. No listing, profile, or comment tables exist.
- `DB_CONNECTION` is `sqlite` in [`.env.example`](.env.example), and `config/database.php` also supports MySQL, MariaDB, PostgreSQL, and SQL Server. The example environment uses database-backed sessions, cache, and queues.
- Vite builds the frontend with Tailwind CSS v4. DaisyUI is not installed.
- No custom middleware aliases, policies, request classes, rate limits, exception classes, custom error views (including 401/402/403/404/419/429/500/503), or custom pagination views are present.

## Project structure

```text
app/
  Http/Controllers/Controller.php                 # Base controller
  Models/User.php                                 # Authenticatable user model
  Providers/AppServiceProvider.php                # Application service provider
bootstrap/
  app.php                                         # Route registration and exception handling
config/
  database.php                                    # Database drivers; SQLite default
database/
  factories/UserFactory.php                      # User factory and default hashed password
  migrations/
    0001_01_01_000000_create_users_table.php       # Users, password-reset tokens, sessions
    0001_01_01_000001_create_cache_table.php       # Cache and cache locks
    0001_01_01_000002_create_jobs_table.php        # Jobs, batches, failed jobs
  seeders/DatabaseSeeder.php                      # Seeds the fixed test user
resources/
  css/app.css                                     # Tailwind CSS entry point
  views/index.blade.php                           # Empty home view
routes/
  console.php                                     # Inspire console command
  web.php                                         # Named home route
tests/
  Feature/ExampleTest.php                         # Checks that / returns HTTP 200
  TestCase.php                                    # Laravel feature-test base
  Unit/ExampleTest.php                            # PHPUnit unit smoke test
```

## Setup

### Quick start

```bash
git clone https://github.com/AngeArsene/le-nkang.git
cd le-nkang
composer run setup
php artisan db:seed
composer run dev
```

`composer run setup` installs Composer dependencies, copies `.env.example` if `.env` is missing, generates the app key, runs migrations with `--force`, installs npm dependencies with scripts disabled, and builds the frontend. It does not seed the database.

There are no default-user environment variables to set. Seeding creates `Test User` / `test@example.com`; there is no password validation rule, and the factory's default password is `password` (hashed). See [`DatabaseSeeder.php`](database/seeders/DatabaseSeeder.php) and [`UserFactory.php`](database/factories/UserFactory.php). This is a development test account, not a production credential.

`composer run dev` invokes `php artisan dev`.

### Manual steps

1. `composer install`
2. `cp .env.example .env`
3. `php artisan key:generate`
4. Configure the database in `.env`. The example uses SQLite; connection options are in [`config/database.php`](config/database.php).
5. `npm install`
6. `npm run build` (or use `npm run dev` during development)
7. `php artisan migrate`
8. There are no `DEFAULT_USER_*` variables to set. Seed the fixed test user with `php artisan db:seed`; its factory password is `password` (hashed), with no password validation rule. See [`UserFactory.php`](database/factories/UserFactory.php).
9. `php artisan serve`

Laravel Herd is an alternative local PHP environment on Windows and macOS.

## AI tooling

Laravel Boost is installed. [`boost.json`](boost.json) enables guidelines, although `.ai/guidelines/` is not present in this checkout; project skills are in [`.ai/skills/`](.ai/skills/). The configured agents are `claude_code`, `opencode`, and `copilot`; generated agent files include [`AGENTS.md`](AGENTS.md) and [`CLAUDE.md`](CLAUDE.md), while `.github/copilot-instructions.md` is absent. Run `php artisan boost:update --discover` to sync generated Boost files. MCP configuration is in [`.mcp.json`](.mcp.json) and [`opencode.json`](opencode.json).

## Usage

- Development: `composer run dev` (runs `php artisan dev`); web-only server: `php artisan serve`.
- Tests: `composer run test` clears the config cache and runs `php artisan test`. The project uses PHPUnit, with tests in [`tests/Feature/ExampleTest.php`](tests/Feature/ExampleTest.php) and [`tests/Unit/ExampleTest.php`](tests/Unit/ExampleTest.php).
- Formatting: `vendor/bin/pint`. Composer has no dedicated lint or format script.

Pest is not installed.

_Last synced with commit 4f644c7 (2026-10-24)_
