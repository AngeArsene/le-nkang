---
name: create-readme
description: Create or refresh the full README.md of the Le Nkang Laravel project (adults-only escort listings directory for Cameroon, Laravel 13 / PHP 8.4, Blade, Tailwind v4, DaisyUI) so it matches the current code. Use whenever the user asks to create, generate, rewrite, refresh or resync the README of Le Nkang, to document the project, or says "README", "documenter le projet", "mettre à jour la doc du projet" for the whole project (not just one feature branch; for a branch-only update use le-nkang-update-readme).
---

# Le Nkang: create or refresh README.md

Act as a senior Laravel engineer maintaining project documentation. Produce a README that reflects what the code actually does today. Accuracy matters more than completeness: a wrong command or class name in a README is worse than a missing one, so verify everything against source.

Do not assume the database driver (SQLite or MySQL); read it from `.env.example` and `config/database.php`.

## 1. Scope the review efficiently

Do not crawl the whole repo. Check only:

- `bootstrap/app.php`: route file registration, middleware aliases, exception wiring
- `routes/*.php`: endpoints, route names, throttle/middleware per route
- `app/Models/`, `app/Http/Controllers/`, `app/Http/Requests/`, `app/Policies/`: domain logic (escorts, comments, auth, profile); use real class/method names
- `app/Http/Middleware/`: custom guards and their registered aliases
- `app/Exceptions/`, `app/Enums/`, `app/View/Components/`: actual classes and purposes
- `resources/views/` top-level structure (layouts, errors, pagination, escorts, auth)
- `database/migrations/`, `database/seeders/`, `database/factories/`: schema shape (including later-added columns) and seeder class names
- `config/` files exposing env values referenced in `.env.example`
- `composer.json` (`scripts` for `setup`/`dev`/`test`/lint: what each really runs) and `package.json`
- `.env.example`: required config, DB driver, and any default-user variables (e.g. `DEFAULT_USER_*`)
- Where the default user's password is validated (seeder, FormRequest, `Password::defaults()`): state the actual rule found
- `tests/`: actual framework (Pest or PHPUnit; check `composer.json` and file syntax) and file paths
- Laravel Boost: `composer.json` (`laravel/boost`), `.ai/guidelines/`, `.ai/skills/`, MCP config (`.mcp.json`, `opencode.json`, `.vscode/mcp.json`) and generated agent files (`CLAUDE.md`, `AGENTS.md`, `.github/copilot-instructions.md`)
- Existing `README.md`, if present

## 2. Check commit history

Run `git log --oneline -20`. Identify the latest commit hash/date and whether meaningful features shipped since the README was last updated.

If nothing changed since the last sync commit, say so and skip rewriting.

## 3. Update README.md

Preserve accurate existing content; rewrite only what is stale or missing. Fix any wording left over from the starter project (e.g. "microblogging", "short messages", "chirps").

Sections, in order:

- **Title & tagline**: `Le Nkang`, one line: what it is and the stack.
- **What the app does**: one short paragraph: visitors browse a paginated directory of escort listings; registered users manage their own profile and listings; what protects ownership-sensitive actions (middleware/policies). Verify each claim against routes and controllers.
- **Features**: specific technical bullets grounded in step 1 (real controller/method names, middleware aliases, throttle/authorization config, schema details such as nullable/unique columns added later, custom error views for 401/402/403/404/419/429/500/503, custom pagination views). Never generic when the mechanism is known.
- **Project structure**: fenced tree of files/folders actually found, each comment naming the real classes/files inside. Omit folders that don't exist.
- **Setup**: two paths, both ending with a seeded default user (if the project seeds one).
  - **Quick start**, in order: `git clone <repo-url>`; `composer run setup` (only if the script exists; say what it actually does); set the default-user variables in `.env` before seeding (state the real password rule with a relative link to its source file); `php artisan db:seed` (skip only if `setup` already seeds, and say so); `composer run dev` (say what it starts).
  - **Manual steps**: `composer install`, `cp .env.example .env`, `php artisan key:generate`, configure the database in `.env`, `npm install`, `npm run build` (or `dev`), `php artisan migrate`, set default-user variables, `php artisan db:seed`, `php artisan serve`. Mention Laravel Herd as an alternative on Windows/macOS.
- **AI tooling** (only if Boost is installed): one short subsection: guidelines in `.ai/guidelines/`, custom skills in `.ai/skills/`, `php artisan boost:update --discover` to sync, and which agents are configured (read them from the Boost config; do not guess).
- **Usage**: actual commands only: dev server, the configured test runner, and the lint/format command exactly as in `composer.json`. If a commonly expected tool isn't present, say so in one line.
- **Status footer**: `_Last synced with commit <hash> (<date>)_`

## Guidelines

- Terse. No filler, no marketing language.
- GitHub Flavored Markdown, relative links only, linking directly to source files when citing a rule or class.
- No API docs, license text or full CONTRIBUTING content.
- Never fabricate command names, class names, paths, columns or validation rules; verify against source first.
