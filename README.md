# Le Nkang

18+ escort-listings directory for Cameroon — currently a Laravel 13 / PHP 8.4 scaffold using Blade, Tailwind CSS v4, and Vite.

## What the app does

Le Nkang is an adults-only listings directory for Cameroon. The current Laravel app exposes public announcement detail pages at `/announcements/{slug}`, renders a polished gallery-style layout for each listing, and tracks the number of times each listing is viewed; the root `/` route still resolves to an empty index view.

## Features

- [`routes/web.php`](routes/web.php) keeps the empty `home` view at `/` while exposing `AnnouncementController::show()` through `Route::resource('announcements', AnnouncementController::class)->only(['show'])`, so public announcement pages live under `/announcements/{slug}`.
- [`App\Models\Announcement`](app/Models/Announcement.php) uses the `slug` as the route key and includes scoped queries for `matching` and `otherThan`, while [`AnnouncementController`](app/Http/Controllers/AnnouncementController.php) resolves the correct Blade view and dispatches a `AnnouncementViewedEvent` before rendering the page.
- [`database/migrations/2026_10_25_154303_create_announcements_table.php`](database/migrations/2026_10_25_154303_create_announcements_table.php) creates the `announcements` table with `slug`, `title`, `description`, and timestamps; [`database/migrations/2026_11_06_091605_add_views_count_to_announcements_table.php`](database/migrations/2026_11_06_091605_add_views_count_to_announcements_table.php) adds the `views_count` column with a default of `0`.
- [`App\Actions\Announcements\Show`](app/Actions/Announcements/Show.php) dispatches `AnnouncementViewedEvent`, and [`App\Listeners\IncrementViewsCount`](app/Listeners/IncrementViewsCount.php) increments the announcement's `views_count` on each view.
- [`database/seeders/DatabaseSeeder.php`](database/seeders/DatabaseSeeder.php) calls [`AnnouncementSeeder`](database/seeders/AnnouncementSeeder.php), which seeds ten sample announcements via [`AnnouncementFactory`](database/factories/AnnouncementFactory.php); the factory generates a unique slug, title, and paragraph-length description.
- [`resources/views/announcements/show.blade.php`](resources/views/announcements/show.blade.php) and the Blade components in [`resources/views/components/announcements/`](resources/views/components/announcements) render a dark luxury listing detail page with the hero, gallery, meta information, safety notes, and related-listing cards.
- [`App\Policies\AnnouncementPolicy`](app/Policies/AnnouncementPolicy.php) allows guests to view a listing while leaving create/update/delete actions blocked, so the public read flow is intentionally open without a login system.
- `DB_CONNECTION` is still `sqlite` in [`.env.example`](.env.example); Laravel's default database configuration remains available for MySQL, MariaDB, PostgreSQL, and SQL Server.

## Project structure

```text
app/
  Actions/Action.php                              # Base action class
  Actions/Announcements/Show.php                  # Dispatches the announcement view event
  Concerns/ResolvesViewFromRoute.php             # Resolves route-specific Blade views
  Events/AnnouncementViewedEvent.php             # Announcement view event
  Http/Controllers/AnnouncementController.php    # Public detail controller for listings
  Http/Controllers/Controller.php                 # Base controller
  Http/Requests/StoreAnnouncementRequest.php     # Placeholder announcement create request
  Http/Requests/UpdateAnnouncementRequest.php    # Placeholder announcement update request
  Listeners/IncrementViewsCount.php               # Increments announcement views
  Models/Announcement.php                         # Slug-based announcement model
  Policies/AnnouncementPolicy.php                 # Public read policy
  Providers/AppServiceProvider.php                # Application service provider
bootstrap/
  app.php                                         # Route registration and exception handling
config/
  database.php                                    # Database drivers; SQLite default
database/
  factories/AnnouncementFactory.php               # Factory for announcement records
  migrations/
    2026_10_25_154303_create_announcements_table.php # Creates the announcements table
    2026_11_06_091605_add_views_count_to_announcements_table.php # Adds views_count
  seeders/
    AnnouncementSeeder.php                        # Seeds ten sample listings
    DatabaseSeeder.php                            # Runs announcement seeding
resources/
  css/app.css                                     # Tailwind CSS entry point
  js/app.js                                       # Vite frontend entry point
  views/
    announcements/show.blade.php                  # Public listing detail page
    components/announcements/about.blade.php      # About section card
    components/announcements/gallery.blade.php    # Gallery and media card
    components/announcements/hero.blade.php       # Listing hero details
    components/announcements/listing-card.blade.php # Listing cards and summary
    components/announcements/related-listings.blade.php # Related discovery cards
    components/announcements/safety.blade.php     # Safety/info panel
    index.blade.php                               # Empty home view
    layouts/main.blade.php                        # Main app shell
routes/
  console.php                                     # Inspire console command
  web.php                                         # Home route and announcement detail routes
tests/
  Feature/AnnouncementTest.php                    # Covers slug URLs, access, escaping, and view counts
  Feature/ExampleTest.php                         # Checks that / returns HTTP 200
  Feature/SanityTest.php                          # Sanity checks for the app
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

There are no default-user environment variables to set; `php artisan db:seed` populates sample announcements via [`DatabaseSeeder.php`](database/seeders/DatabaseSeeder.php) and [`AnnouncementSeeder.php`](database/seeders/AnnouncementSeeder.php).

`composer run dev` invokes `php artisan dev`.

### Manual steps

1. `composer install`
2. `cp .env.example .env`
3. `php artisan key:generate`
4. Configure the database in `.env`. The example uses SQLite; connection options are in [`config/database.php`](config/database.php).
5. `npm install`
6. `npm run build` (or use `npm run dev` during development)
7. `php artisan migrate`
8. There are no `DEFAULT_USER_*` variables to set. Seed the sample announcement records with `php artisan db:seed`; [`AnnouncementSeeder.php`](database/seeders/AnnouncementSeeder.php) creates ten generated listings via [`AnnouncementFactory.php`](database/factories/AnnouncementFactory.php).
9. `php artisan serve`

Laravel Herd is an alternative local PHP environment on Windows and macOS.

## AI tooling

Laravel Boost is installed. [`boost.json`](boost.json) enables guidelines, although `.ai/guidelines/` is not present in this checkout; project skills are in [`.ai/skills/`](.ai/skills/). The configured agents are `claude_code`, `opencode`, and `copilot`; generated agent files include [`AGENTS.md`](AGENTS.md) and [`CLAUDE.md`](CLAUDE.md), while `.github/copilot-instructions.md` is absent. Run `php artisan boost:update --discover` to sync generated Boost files. MCP configuration is in [`.mcp.json`](.mcp.json) and [`opencode.json`](opencode.json).

## Usage

- Development: `composer run dev` (runs `php artisan dev`); web-only server: `php artisan serve`.
- Tests: `composer run test` clears the config cache and runs `php artisan test`. The project uses PHPUnit, with announcement-specific checks in [`tests/Feature/AnnouncementTest.php`](tests/Feature/AnnouncementTest.php) and a baseline sanity check in [`tests/Feature/SanityTest.php`](tests/Feature/SanityTest.php).
- Formatting: `vendor/bin/pint`. Composer has no dedicated lint or format script.

Pest is not installed.

_Last synced with commit 5835440 (2026-11-08)_
