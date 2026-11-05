---
name: update-docblocks
description: Scan one or more PHP files given as arguments (e.g. `/update-docblocks @tests/Feature/AnnouncementTest.php`) and add or fix PHPDoc blocks on every undocumented or poorly documented class, interface, trait, enum, enum case, constant, property and method, following PSR-5/PHPDoc conventions. With no argument, fall back to the uncommitted git changes of the Le Nkang Laravel 13 / PHP 8.4 project. Use whenever the user passes a file or folder, says "documente ce fichier", "ajoute les docblocks", "update docblocks", "scan and update docblocks", "documente mes changements", or wants PHPDoc kept in sync before a commit. Applies to tests, models, controllers, policies, requests, enums, components. Never touches .blade.php files.
---

# Le Nkang: update PHPDoc on given files (or on uncommitted changes)

Act as a senior Laravel/PHP engineer maintaining inline documentation. Your job is to WRITE doc blocks, not to decide whether the file "needs" them. An undocumented element always needs a block.

Le Nkang: adults-only (18+) escort listings directory for Cameroon, Laravel 13 / PHP 8.4. Read the Boost-generated guidelines (`CLAUDE.md`, `AGENTS.md`, `.github/copilot-instructions.md`, `.ai/guidelines/`) if present, and match the doc style already used in the repo (check 2-3 documented files, and `larastan`/`phpstan` in `composer.json` for generics style).

## 0. Pick the mode (do this first)

- **File mode** (default when the user passes a path, `@path`, a glob, or a folder): the arguments ARE the scope. Go to section 1. The git state is irrelevant in this mode.
- **Changes mode** (only when NO file or path argument was given): go to section 5.

Hard rules for file mode:

- NEVER run `git status` / `git diff` to decide whether to act. A clean working tree, an already committed file or an unmodified file does NOT mean "nothing to do". Do not stop, do not answer "no changes", do not ask for confirmation.
- NEVER refuse, skip or answer "already fine" without first reading the file and checking every element against section 3. If at least one element fails the check, you MUST edit the file.
- Only report "nothing to document" after the full check found zero failing elements, and name how many elements you checked.

## 1. Resolve the targets

- Accept paths in any form (`@tests\Feature\AnnouncementTest.php`, `tests/Feature/AnnouncementTest.php`, several paths, a glob, a folder). Strip a leading `@`, normalize `\` to `/`, resolve relative to the project root.
- Folder or glob: expand to `*.php` files, recursively.
- Drop every `*.blade.php`, `vendor/`, `storage/`, `bootstrap/cache/` and generated files. If the user explicitly named a Blade file, skip only that file and say why.
- If a path does not exist, say so for that path and continue with the others.
- If a file mixes PHP with something unexpected, skip it and flag it.

## 2. Read, then inventory

Read each target file in full. List every documentable element:

- class, interface, trait, enum (and `abstract`/`final`/`readonly` ones), anonymous classes only if they have members worth documenting
- constants and enum cases
- properties, including promoted constructor properties
- methods and functions of any visibility, including `setUp`, `tearDown`, data providers, closures assigned to named properties
- Pest/test files without classes: file-level `describe`/`it`/`test` blocks are not documented with PHPDoc, but helper functions, classes, traits, datasets and any named method in the file are

Test classes and test methods are first-class targets: document them like any other code (what behavior the test asserts, not how).

## 3. Decide per element: keep, fix or add

An element is **already fine** only if ALL of these hold:

- it has a `/** ... */` block;
- the description is meaningful (not empty, not a placeholder like `TODO`, not just the element name restated);
- every parameter has a correct `@param` where a tag is useful (see section 4), none is missing or stale;
- `@return`, `@var`, `@throws` match the current signature and body;
- the types are as precise as the project's static analysis style expects (generics, array shapes).

Otherwise it is **undocumented or poorly documented**: add or rewrite the block. Typical failures to fix:

- no block at all;
- empty or one-word or name-restating description;
- missing `@param` for one or more parameters, or a wrong name/type/order;
- `@return` that contradicts the native return type, or a bare `array`/`Collection` where the project documents generics;
- `//` or `/* */` comments used instead of a `/** */` block above a member (convert them);
- block present but describing behavior the code no longer has.

Leave blocks that pass the check exactly as they are. Do not churn good documentation.

## 4. Format rules (PSR-5 / PHPDoc)

- `/** ... */` PHPDoc, aligned with the element's indentation, placed directly above the element (above attributes is fine, keep the project's existing order).
- Summary is one line, under 130 characters, ending with a period, imperative or descriptive, not a paragraph, no restating the name. Add a blank `*` line and a short second paragraph only when a non-obvious rule must be stated.
- Never include `@example` or usage snippets.
- Tags only where useful, in this order: `@param`, `@return`, `@throws`, others.
  - `@param <type> $name` per parameter, with a short description only when the name and type do not say enough.
  - `@return <type>` for non-void methods when the native type is not precise enough (generics such as `HasMany<Comment, $this>`, `Collection<int, Escort>`, array shapes) or when the project already always uses it. For `void` tests and setters, omit `@return`.
  - `@throws` only for exceptions visibly thrown in the body or declared in a called method's doc.
  - `@var <type>` for properties/constants whose native type is not precise.
  - `@dataProvider`/`@covers`-style tags: keep existing ones, do not invent new ones. If the file uses PHPUnit attributes, do not duplicate them as tags.
- Do not repeat in `@param`/`@return` what the native type already states perfectly and the project does not repeat.
- No `@author`, `@package`, `@since`.
- Language of the descriptions: follow the language already dominant in the repo's docblocks; default to English.

## 5. Changes mode (no argument given)

Only when no file or path was passed:

1. Run `git status --porcelain`. Buckets: **Added** (`??`, `A`), **Modified** (`M`, `AM`, `MM`, `R` renamed with edits). Keep only `*.php`, apply the filters from section 1. If nothing remains, say so and stop.
2. **Added files**: full pass, sections 2 to 4 over the whole file.
3. **Modified files**: run `git diff HEAD -- <file>` and read the hunks. Document only newly added methods and existing methods whose signature, return type, visibility or logic changed. Add or rewrite their block if missing or now inaccurate. Leave every other block as-is.

## Guidelines

- Terse. No filler. No invented behavior; base everything on code you read. For tests, describe the asserted behavior from the test body.
- Do not reformat, rename or reorder code. Do not run a formatter or linter. Only add or edit doc blocks (and convert misplaced comments into doc blocks).
- Edit the files in place. Do not print the whole file back.
- Finish with a short report: for each file, the number of elements checked, the elements documented or fixed (by name), and the elements left untouched because they were already fine. Flag any skipped file and the reason.
