---
agent: 'agent'
description: 'Create an error layout component and branded error views (401, 402, 403, 404, 419, 429, 500, 503) matching the Le Nkang design'
---

## Role
You are a senior Laravel/Blade developer on Le Nkang. You write idiomatic Laravel 13 and Tailwind CSS v4 + DaisyUI views that look native to the app.

## Context
- Laravel 13 / PHP 8.4, Blade (class-based and anonymous components), Tailwind CSS v4 + DaisyUI.
- Existing layout component: `app/View/Components/Layouts/Main.php`, rendering a blade file under `resources/views/layouts/`.
- Laravel Boost is installed. Read its generated guidelines (`CLAUDE.md`, `AGENTS.md`, `.github/copilot-instructions.md`, `.ai/guidelines/`) and use Boost MCP tools (e.g. `application-info`, `list-routes`, `search-docs`) instead of guessing.
- Error views live in `resources/views/errors/{code}.blade.php`.

## Task
Do these steps **in order**.

### Step 1: Read the codebase first
1. `app/View/Components/Layouts/Main.php`: namespace, imports, constructor, public properties/methods (note its exact naming style, e.g. `page_title()`), what `render()` returns.
2. The blade file it renders: `<head>` (Vite directives, meta, fonts, favicon), body classes, `{{ $slot }}` placement, footer, shared partials.
3. Existing files in `resources/views/errors/` (if any) and any `exceptions` rendering in `bootstrap/app.php`.
4. One or two content views (e.g. `resources/views/escorts/index.blade.php`, `resources/views/auth/login.blade.php`): exact color tokens, spacing, button and card classes, typography scale; note the centered-card pattern of the auth layout.
5. `resources/css/app.css`: `@theme` tokens, custom properties, DaisyUI theme config.
6. `routes/*.php`: the real route names for home and login (do not assume `escorts.index` or `login`).

### Step 2: Create `app/View/Components/Layouts/Error.php`
- Class name is exactly `Error` (file `Error.php`) so Laravel auto-discovers `<x-layouts.error>`.
- Mirror `Main.php` (namespace, `extends Component`, import style, PHPDoc style: one-line descriptions, no `@example`).
- Constructor takes only an optional `public string $title = ''`. It must not require anything unavailable at error-render time.
- Title helper (use the same naming style as `Main`, e.g. `page_title()`): returns `$title . ' - ' . config('app.name')` when `$title` is not empty, otherwise `config('app.name')`. Do not use `Route::currentRouteName()`; it is null on 404s.
- Import everything used (`Closure`, `Illuminate\Contracts\View\View`, etc.).
- `render()` returns `view('layouts.error')`.

### Step 3: Create `resources/views/layouts/error.blade.php`
- Copy `<head>` from the main layout verbatim (Vite, meta, fonts, favicon), but use the title helper for `<title>`.
- No authenticated navigation, no `@auth`/`@guest`, no `@csrf`, no session or database access: error pages (especially 419, 500 and 503 during maintenance mode) must render without them.
- Same `<body>` background, font stack and DaisyUI theme as the main layout.
- Center `{{ $slot }}` using the same pattern as the auth layout if it is a centered card; include the main layout's footer markup or a minimal consistent version.

### Step 4: Create the eight error views
Each view wraps its content in `<x-layouts.error title="...">`, shows the status code large (typographic scale from the project), one short friendly message, and one CTA using the exact primary button classes found in Step 1. No walls of text. Default CTA: "Go back home" linking to the real home route found in Step 1.

| File | title | Heading | Message | CTA |
|---|---|---|---|---|
| `401.blade.php` | `401 — Unauthorized` | `401` | You need to be logged in to access this page. | "Sign in" → real login route |
| `402.blade.php` | `402 — Payment Required` | `402` | Access to this page requires an active subscription. | default |
| `403.blade.php` | `403 — Forbidden` | `403` | You don't have permission to access this page. | default |
| `404.blade.php` | `404 — Not Found` | `404` | The page you're looking for doesn't exist or has been moved. | default |
| `419.blade.php` | `419 — Page Expired` | `419` | Your session has expired. Please refresh the page and try again. | "Refresh" with `onclick="window.location.reload()"` |
| `429.blade.php` | `429 — Too Many Requests` | `429` | You've made too many requests in a short period. Please wait a moment and try again. | default |
| `500.blade.php` | `500 — Server Error` | `500` | Something went wrong on our end. We're working on it. | default |
| `503.blade.php` | `503 — Under Maintenance` | `503` | Le Nkang is temporarily down for maintenance. Please check back shortly. | none (the home page is also down) |

### Step 5: Verify discovery
Confirm `App\View\Components\Layouts\Error` maps to `<x-layouts.error>` without manual registration. If `AppServiceProvider` registers a custom component namespace, follow it. Do not edit `config/app.php`.

### Step 6: Sanity check
Run and report any error:

```bash
php artisan view:clear
php artisan config:clear
php artisan route:list
```

Then render each error view once (a Pest/PHPUnit feature test or `php artisan tinker`) and fix any failure. If the project has tests, add a small feature test asserting the 404 page returns 404 and contains the heading.

## Quality rules
- Visual consistency is the goal: copy real class names from existing views; do not invent any.
- No inline styles. No hardcoded colors; use existing tokens/aliases.
- Match indentation, quote style and Blade formatting of the files read in Step 1.
- Do not run a formatter on unrelated files.
