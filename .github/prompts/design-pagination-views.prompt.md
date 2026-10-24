---
agent: 'agent'
description: 'Design the custom pagination views (pagination.paginate and pagination.simple-paginate) with Tailwind CSS + DaisyUI, consistent with Le Nkang'
---

## Role
You are a senior Laravel/Blade developer on Le Nkang. You write clean Blade with Tailwind CSS v4 + DaisyUI that looks native to the app.

## Context
- Laravel 13 / PHP 8.4, Blade, Tailwind CSS v4 + DaisyUI.
- Laravel Boost is installed: read its generated guidelines (`CLAUDE.md`, `AGENTS.md`, `.github/copilot-instructions.md`, `.ai/guidelines/`) and use Boost MCP tools (e.g. `search-docs`, `list-routes`) instead of guessing.
- Custom views are expected to be registered in `AppServiceProvider::boot()`:
  - `Paginator::defaultView('pagination.paginate')` → `resources/views/pagination/paginate.blade.php`
  - `Paginator::defaultSimpleView('pagination.simple-paginate')` → `resources/views/pagination/simple-paginate.blade.php`

## Task
Do these steps **in order**.

### Step 1: Read first
1. `app/Providers/AppServiceProvider.php`: confirm the two registrations and their exact view names. If a `Paginator::useBootstrap*()`/`useTailwind()` call also exists, note that whichever runs last wins, report it, and remove it only if it is redundant.
2. The main layout blade file (what `App\View\Components\Layouts\Main` renders): body background, font stack, DaisyUI/Tailwind tokens.
3. Every view that calls `->links()` (search `resources/views` with grep, starting with `resources/views/escorts/index.blade.php`): surrounding container/spacing.
4. Two or three content views (e.g. `auth/login.blade.php`, escort cards): exact primary and secondary button classes.
5. `resources/css/app.css`: `@theme` tokens and DaisyUI theme.
6. Both pagination views. If either already contains real markup, stop and ask before overwriting; if it is an empty placeholder, continue.

### Step 2: `pagination/paginate.blade.php`
- Receives `$paginator` and `$elements`. Wrap everything in `@if ($paginator->hasPages())`.
- Wrap in `<nav role="navigation" aria-label="Pagination">`; use `aria-current="page"` on the current page, `aria-disabled` on disabled controls, `rel="prev"`/`rel="next"` on the arrows.
- **Window:** at most 3 pages before and 3 after the current page. Always show first and last page, and an ellipsis (`...`, non-interactive) where pages are skipped. Build the window from `$paginator->currentPage()`, `$paginator->lastPage()` and `$paginator->url($page)`, not from all `$elements`.
- **Layout:** one centered row: « Previous (left), page buttons (middle), Next » (right).
- Previous/Next use the project's primary/accent button classes (not bare `btn`). On first/last page render a non-link element with `btn-disabled` and no `href`.
- Current page uses the active DaisyUI variant that matches the project's color scheme.
- Make the row wrap or shrink gracefully on small screens (hide numbers beyond ±1 on mobile if needed, using responsive utilities).
- Use only existing Tailwind/DaisyUI classes and tokens; no inline styles; no hardcoded colors.

### Step 3: `pagination/simple-paginate.blade.php`
- Used by `simplePaginate()`: Previous and Next only, no numbers.
- Render only if `$paginator->hasPages()`. Same nav/aria rules.
- « Previous disabled (`btn-disabled`, no `href`) when `$paginator->onFirstPage()`; Next » disabled when `! $paginator->hasMorePages()`.
- Reuse the exact button classes from `paginate.blade.php`.

### Step 4: Verify
Run and report errors:

```bash
php artisan view:clear
php artisan config:clear
php artisan route:list
```

Then confirm: `->links()` renders `pagination.paginate`; the window is ±3; Previous/Next are visually distinct; disabled states work on first and last page. If the project has tests, add a feature test that requests page 2 of a paginated listing and asserts the pagination markup is present.

## Quality rules
- Visual consistency first: reuse real class names from existing views.
- Match indentation, Blade formatting and quote style of the files read in Step 1.
- Do not run a formatter on unrelated files.
