---
name: update-docblocks
description: Scan the uncommitted git changes of the Le Nkang Laravel 13 / PHP 8.4 project and add or update PHPDoc blocks only on the added or modified PHP files (new methods, changed signatures). Use whenever the user asks to document their current changes, "scan and update docblocks", "documente mes changements", wants PHPDoc kept in sync before a commit, or asks to update doc blocks after editing. For documenting one whole file use le-nkang-create-docblocks. Never touches .blade.php files.
---

# Le Nkang: scan and update PHPDoc on uncommitted changes

Act as a senior Laravel/PHP engineer maintaining inline documentation. Limit the work to what changed so the commit stays focused and existing documentation is not churned.

Le Nkang: adults-only (18+) escort listings directory for Cameroon, Laravel 13 / PHP 8.4. Read the Boost-generated guidelines (`CLAUDE.md`, `AGENTS.md`, `.github/copilot-instructions.md`, `.ai/guidelines/`) if present, and match the doc style already used in the repo (check 2-3 documented files, and `larastan`/`phpstan` in `composer.json` for generics style).

## 1. Detect changes

- Run `git status --porcelain`.
- Buckets: **Added** (`??`, `A`), **Modified** (`M`, `AM`, `MM`, `R` renamed with edits).
- Keep only `*.php`; drop every `*.blade.php`, `vendor/`, `storage/`, `bootstrap/cache/`, and generated files.
- If nothing remains, say so and stop.

## 2. Added files: full pass

Add a doc block above the class/interface/trait/enum, every property (including promoted constructor properties), constant, enum case, and every method (any visibility). Skip elements that already have a correct block.

## 3. Modified files: targeted pass

- Run `git diff HEAD -- <file>` (covers staged and unstaged) and read the hunks.
- Document only newly added methods and existing methods whose signature, return type, visibility or logic changed. Add or rewrite their block if missing or now inaccurate (e.g. new parameter without `@param`).
- Leave every other doc block exactly as-is.

## 4. Format rules

- `/** ... */` PHPDoc.
- Description is one line, under 130 characters, not a paragraph, no restating the name.
- Never include `@example` or usage snippets.
- Tags only where useful:
  - `@param <type> $name` per parameter.
  - `@return <type>` for non-void methods when the native type is not precise enough (generics such as `HasMany<Comment, $this>`, `Collection<int, Escort>`, array shapes) or when the project already always uses it.
  - `@throws` only for exceptions visibly thrown in the body or declared in a called method's doc.
  - `@var <type>` for properties/constants whose native type is not precise.
- No `@author`, `@package`, `@since`.

## Guidelines

- Terse. No filler. No invented behavior; base everything on code you read.
- Do not reformat, rename or reorder code. Do not run a formatter or linter.
- If a file mixes PHP with something unexpected, skip it and flag it.
- Finish by listing touched files and, for modified files, the specific methods added or updated.
