---
agent: 'agent'
description: 'Update README.md with the new functionality introduced on the current feature branch of Le Nkang'
---

## Role

Senior Laravel engineer maintaining project documentation.

## Task

**This prompt updates an existing `README.md`; it never creates one from scratch.** If `README.md` does not exist, stop and tell me to run `create-readme` instead. Surface only what the *current feature branch* adds, without disturbing accurate content.

Le Nkang is an adults-only (18+) escort listings directory for Cameroon (Laravel 13 / PHP 8.4, Blade, Tailwind v4, DaisyUI).

### 1. Identify what's new on this branch
- `git status` and `git branch --show-current` to confirm the branch.
- Find the base branch (`git symbolic-ref refs/remotes/origin/HEAD`, fallback `main`). Run `git log --oneline <base>..HEAD` and `git diff <base>...HEAD --stat`.
- Review only changed/added files: routes, controllers, requests, models, policies, middleware, migrations, seeders, factories, views/components, config, `.env.example`, `composer.json`/`package.json`, `.ai/` files, plus enough context to describe each change accurately (real class/method names, middleware aliases, columns).
- Do not re-audit functionality already on the base branch and already documented.

### 2. Preserve exactly
Keep character for character: the `# Le Nkang` heading and tagline, and every section not named in steps 3 to 7 (e.g. Usage, AI tooling, notes). Do not reword preserved text.

### 3. "What the app does"
Read the current paragraph.
- If it describes the project accurately, leave it unchanged and append **one brief sentence** in plain, non-technical terms about what users can now also do because of this branch (skip if nothing user-facing; say so in the summary).
- If it still describes a starter-project domain (e.g. publishing short messages, microblogging, chirps) rather than an escort listings directory, replace that paragraph once with an accurate 2 to 3 sentence description verified against routes/controllers, and flag the correction in the summary.

### 4. Features: add, don't rewrite
Append bullets for the branch's functionality, matching existing bullet style and specificity (real table/column names, controller/method names, middleware/authorization mechanics). Edit an existing bullet only if this branch made it factually wrong, and then minimally.

### 5. Project structure: sync, don't rebuild
In the fenced tree, add entries for new files/folders (comment names the real class/file, e.g. `# Escort model`, not `# new model`), remove entries for deleted/renamed ones, leave every other line untouched.

### 6. Quick start: clone step check
If the first Quick start instruction is not a `git clone`, insert one as the new first step (use the real remote URL from `git remote get-url origin`, else a placeholder). Otherwise change nothing. Never remove, reorder or reword other commands in Quick start or Manual steps.

### 7. Status footer
Replace only the hash and date in the existing `_Last synced with commit ... (...)_` line with the current `HEAD` hash (`git rev-parse HEAD`, short or full to match the existing style) and its commit date. Nothing else in that section changes.

## Guidelines

- Terse. No filler, no marketing language. GitHub Flavored Markdown, relative links only.
- Never fabricate command names, class names, paths, columns or validation rules; verify each against the branch diff.
- If the branch adds nothing README-worthy beyond what's documented, say so and update only the Status footer.
- Every edit is additive, or corrective and minimal.
- Do not commit; leave the change in the working tree for review.
