# Copilot instructions for Le Nkang

## Project context

- Laravel 13 / PHP 8.4 application for a Cameroon adults-only listings directory.
- The app is intentionally read-focused: public announcement pages live under `/announcements/{slug}` and the home route is currently a minimal `index` view.
- Frontend stack: Blade templates, Tailwind CSS v4, and Vite. There is no Pest setup; the project uses PHPUnit through Laravel's test runner.

## Build, test, and lint commands

### Initial setup

- `composer install`
- `cp .env.example .env`
- `php artisan key:generate`
- `composer run setup` — installs dependencies, copies `.env` if needed, runs migrations, installs npm dependencies without scripts, and builds frontend assets.

### Daily dev flow

- `composer run dev` — runs `php artisan dev`.
- `php artisan serve` — for a simple web-only local server.
- `npm run build` — production bundle for Vite.
- `npm run dev` — Vite dev server during front-end iteration.

### Testing

- `composer run test` — clears config cache and runs `php artisan test`.
- Single file: `php artisan test tests/Feature/AnnouncementTest.php`
- Single case: `php artisan test --filter=testGuestUserCanViewAnAnnouncement`
- The repo currently has feature checks for announcement routing, escaping, view counting, and related rendering in `tests/Feature/AnnouncementTest.php`.

### Formatting

- `vendor/bin/pint`
- `vendor/bin/pint --dirty --format agent` is the repo-aligned quick pass when finishing PHP edits.

## High-level architecture

- `routes/web.php` keeps `/` simple with `Route::view('/', 'index')` and only exposes `AnnouncementController::show()` for public listing pages.
- `app/Http/Controllers/AnnouncementController.php` is the public entry point for announcement detail pages. It delegates work to `App\Actions\Announcements\Show` and resolves the correct Blade view from the current route name.
- `App\Models\Announcement` is the main domain model. It uses `slug` as the route key and includes scoped queries like `matching()` and `otherThan()`.
- `App\Actions\Announcements\Show` loads the favorite count and dispatches `AnnouncementViewedEvent`.
- `App\Listeners\IncrementViewsCount` listens for that event and updates `announcements.views_count`.
- Blade templates live under `resources/views/` and `resources/views/components/announcements/`. The main app shell is `resources/views/layouts/main.blade.php`, and the public detail page is `resources/views/announcements/show.blade.php`.
- `App\Concerns\ResolvesViewFromRoute` maps route names to view names, so route names and Blade files should stay consistent when adding pages.
- Database defaults remain SQLite-oriented via `.env.example`, but the app is configured to work with standard Laravel-supported DB drivers.

## Key conventions specific to this repo

- Prefer the existing action + event/listener pattern for request-side behavior instead of introducing ad hoc service classes for simple flows.
- Keep public URLs slug-based and route names aligned with the model (`route('announcements.show', $announcement)`).
- The read flow is intentionally open: `AnnouncementPolicy` allows guests to view listings while the create/update/delete actions remain blocked; do not assume an auth layer exists beyond that.
- Use Laravel's conventional PHPUnit style for tests; Pest is not installed.
- Tailwind assets are managed through Vite (`resources/css/app.css`, `resources/js/app.js`, `@vite(...)` in the main layout). Keep frontend changes consistent with those conventions.
- Keep route names and Blade names in sync with `resolveView()` expectations; `home` resolves to `index`, and `.home` route names can fallback to sibling index views.
- The repo already includes Boost-generated agent guidance (`AGENTS.md`, `CLAUDE.md`) and a Laravel Boost MCP configuration in `.mcp.json`; follow that project-level guidance when it applies.

## Notes for future Copilot sessions

- Do not assume the project includes a full admin, auth, or CRUD system beyond the public listing route.
- If a change touches announcement rendering, prefer checking the model, controller, event/listener, and relevant Blade components together rather than patching just one file.
- This project is small but opinionated: route naming, slug behavior, and the view-resolution pattern matter more than a generic Laravel scaffold.
