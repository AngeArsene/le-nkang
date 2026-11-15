# Le Nkang

18+ escort-listings directory for Cameroon — currently a Laravel 13 / PHP 8.4 scaffold using Blade, Tailwind CSS v4, and Vite.

## What the app does

Le Nkang is an adults-only listings directory for Cameroon. The app serves public announcement pages at `/announcements/{slug}`, renders a polished listing layout with gallery, review, and contact details, and tracks both views and saves to a favorites list; the root `/` route still resolves to the landing index view. Visitors can also save listings to favorites and revisit a page without the same guest view being counted again. Each listing now shows its average rating and review count.

## Features

- [`routes/web.php`](routes/web.php) keeps the empty `home` view at `/` while exposing `AnnouncementController::show()` through `Route::resource('announcements', AnnouncementController::class)->only(['show'])`, so public announcement pages live under `/announcements/{slug}`.
- [`App\Models\Announcement`](app/Models/Announcement.php) uses the `slug` as the route key and includes scoped queries for `matching` and `otherThan`, while [`AnnouncementController`](app/Http/Controllers/AnnouncementController.php) resolves the correct Blade view before rendering the page.
- [`database/migrations/2026_10_25_154303_create_announcements_table.php`](database/migrations/2026_10_25_154303_create_announcements_table.php) creates the `announcements` table with `slug`, `title`, `description`, and timestamps; [`database/migrations/2026_11_06_091605_add_views_count_to_announcements_table.php`](database/migrations/2026_11_06_091605_add_views_count_to_announcements_table.php) adds the `views_count` column with a default of `0`.
- [`App\Actions\ViewAnnouncement`](app/Actions/ViewAnnouncement.php) loads `favorites_count` and `reviews_count`, then delegates view counting to [`App\Actions\IncrementViewsCount`](app/Actions/IncrementViewsCount.php), which suppresses repeat guest views during the cookie retention period.
- [`App\Models\Announcement`](app/Models/Announcement.php) exposes a `favorites()` relation through [`app/Models/Favorite.php`](app/Models/Favorite.php), and [`addToFavorites(User $user)`](app/Models/Announcement.php) stores a unique `user_id` / `announcement_id` row via [`database/migrations/2026_11_08_162439_create_favorites_table.php`](database/migrations/2026_11_08_162439_create_favorites_table.php).
- [`database/seeders/DatabaseSeeder.php`](database/seeders/DatabaseSeeder.php) calls [`AnnouncementSeeder`](database/seeders/AnnouncementSeeder.php), which seeds ten sample announcements via [`AnnouncementFactory`](database/factories/AnnouncementFactory.php); the factory generates a unique slug, title, and paragraph-length description.
- [`resources/views/announcements/show.blade.php`](resources/views/announcements/show.blade.php), the Blade components in [`resources/views/components/announcements/`](resources/views/components/announcements), and [`resources/js/app.js`](resources/js/app.js) render the favorites count and allow a guest to toggle a listing in favorites from the public detail page.
- [`App\Actions\IncrementViewsCount`](app/Actions/IncrementViewsCount.php) remembers recently viewed announcement IDs in a cookie so the same guest browser only adds one view per listing within the retention window, while [`database/seeders/FavoriteSeeder.php`](database/seeders/FavoriteSeeder.php) and [`database/seeders/DatabaseSeeder.php`](database/seeders/DatabaseSeeder.php) populate seeded favorite relationships for sample announcements.
- [`database/migrations/2026_11_15_162930_create_reviews_table.php`](database/migrations/2026_11_15_162930_create_reviews_table.php) creates a `reviews` table with `announcement_id`, `first_name`, `note`, and `opinion`; [`App\Models\Announcement::averageRating()`](app/Models/Announcement.php) and `reviews_count` supply the displayed average and total, and [`ReviewSeeder`](database/seeders/ReviewSeeder.php) seeds sample ratings. [`App\Enums\Note`](app/Enums/Note.php) defines rating values from 1 to 5.
- Review submission is not persisted yet: the visible form only updates client-side sample data, [`ReviewController`](app/Http/Controllers/ReviewController.php) actions are empty, [`StoreReviewRequest`](app/Http/Requests/StoreReviewRequest.php) and [`UpdateReviewRequest`](app/Http/Requests/UpdateReviewRequest.php) deny authorization, and [`ReviewPolicy`](app/Policies/ReviewPolicy.php) denies every review operation.
- [`App\Policies\AnnouncementPolicy`](app/Policies/AnnouncementPolicy.php) allows guests to view a listing while leaving create/update/delete actions blocked, so the public read flow is intentionally open without a login system.
- `DB_CONNECTION` is still `sqlite` in [`.env.example`](.env.example); Laravel's default database configuration remains available for MySQL, MariaDB, PostgreSQL, and SQL Server.
- [`tests/Feature/AnnouncementTest.php`](tests/Feature/AnnouncementTest.php) verifies favorite counts and review summaries in the HTTP flow, and [`tests/Browser/AnnouncementBrowserTest.php`](tests/Browser/AnnouncementBrowserTest.php) checks favorites and view counting in a Dusk browser session.

## Project structure

```text
.agents/
  skills/
    domain-organization/SKILL.md                  Domain-based action and DTO guidance
.ai/
  skills/
    domain-organization/SKILL.md                  Domain-based action and DTO guidance
.claude/
  skills/
    domain-organization/SKILL.md                  Domain-based action and DTO guidance
.github/
  copilot-instructions.md                        Copilot repository instructions
  skills/
    domain-organization/SKILL.md                  Domain-based action and DTO guidance
app/
  Actions/Action.php                              # Base action class
  Actions/IncrementViewsCount.php                 # Prevents duplicate guest views via cookie tracking
  Actions/ViewAnnouncement.php                    # Loads favorite/review counts and increments the view count
  Concerns/ResolvesViewFromRoute.php             # Resolves route-specific Blade views
  Enums/Note.php                                  # Five review rating values
  Http/Controllers/AnnouncementController.php    # Public detail controller for listings
  Http/Controllers/Controller.php                 # Base controller
  Http/Controllers/ReviewController.php           # Unimplemented review resource controller scaffold
  Http/Requests/StoreAnnouncementRequest.php     # Placeholder announcement create request
  Http/Requests/UpdateAnnouncementRequest.php    # Placeholder announcement update request
  Http/Requests/StoreReviewRequest.php             # Review submission request; currently denied
  Http/Requests/UpdateReviewRequest.php            # Review update request; currently denied
  Models/Announcement.php                        # Slug-based announcement model with favorites and reviews
  Models/Favorite.php                             # Favorite pivot between users and listings
  Models/Review.php                               # Rating and written review for an announcement
  Policies/AnnouncementPolicy.php                 # Public read policy
  Policies/ReviewPolicy.php                       # Denies all review operations
  Providers/AppServiceProvider.php                # Application service provider
bootstrap/
  app.php                                         # Route registration and exception handling
config/
  database.php                                    # Database drivers; SQLite default
database/
  factories/AnnouncementFactory.php               # Factory for announcement records
  factories/ReviewFactory.php                     # Factory for review records
  migrations/
    2026_10_25_154303_create_announcements_table.php # Creates the announcements table
    2026_11_06_091605_add_views_count_to_announcements_table.php # Adds views_count
    2026_11_08_162439_create_favorites_table.php  # Adds the favorites pivot table
    2026_11_15_162930_create_reviews_table.php    # Creates the reviews table
  seeders/
    AnnouncementSeeder.php                        # Seeds ten sample listings
    DatabaseSeeder.php                            # Runs announcement, favorite, and review seeding
    FavoriteSeeder.php                             # Seeds favorite relationships for sample listings
    ReviewSeeder.php                               # Seeds sample reviews for announcements
resources/
  css/app.css                                     # Tailwind CSS entry point
  js/app.js                                       # Client-side listing, favorites, and review interactions
  views/
    announcements/show.blade.php                  # Public listing detail page with review summary
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
  Browser/
    AnnouncementBrowserTest.php                   # Verifies favorites and view counting in the browser
    Pages/AnnouncementPage.php                    # Browser page object for the announcement detail page
    Pages/HomePage.php                            # Browser page object for the home route
    Pages/Page.php                                # Base Dusk page object
    SlowBrowser.php                               # Adds pauses after visits and clicks in browser tests
  DuskTestCase.php                                # Shared Dusk browser setup
  Feature/AnnouncementTest.php                    # Covers slug URLs, access, escaping, favorites, and review summaries
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

Laravel Boost is installed. [`boost.json`](boost.json) enables guidelines, although `.ai/guidelines/` is not present in this checkout; project skills are in [`.ai/skills/`](.ai/skills/). The configured agents are `claude_code`, `opencode`, and `copilot`; generated agent files include [`AGENTS.md`](AGENTS.md), [`CLAUDE.md`](CLAUDE.md), and [`.github/copilot-instructions.md`](.github/copilot-instructions.md). Run `php artisan boost:update --discover` to sync generated Boost files. MCP configuration is in [`.mcp.json`](.mcp.json) and [`opencode.json`](opencode.json).

## Usage

- Development: `composer run dev` (runs `php artisan dev`); web-only server: `php artisan serve`.
- Tests: `composer run test` clears the config cache and runs `php artisan test`. The project uses PHPUnit, with announcement-specific checks in [`tests/Feature/AnnouncementTest.php`](tests/Feature/AnnouncementTest.php) and a baseline sanity check in [`tests/Feature/SanityTest.php`](tests/Feature/SanityTest.php).
- Formatting: `vendor/bin/pint`. Composer has no dedicated lint or format script.

Pest is not installed.

_Last synced with commit 4e6b209 (2026-11-15)_
