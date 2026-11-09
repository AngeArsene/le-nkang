---
name: update-readme
description: >-
  Update an existing Le Nkang README.md with only what changed since the last
  commit mentioned at the end of the README (the "Last synced with commit"
  footer): new features, files, structure entries, status footer. Covers added,
  modified, deleted, renamed and untracked files, committed or not. Leaves all
  accurate content untouched. Also audits the docblocks of added, modified,
  renamed and untracked source files and runs /update-docblocks on those that
  are missing, outdated or incoherent. Use whenever the user wants to document
  a feature branch, update the README before a PR or merge, or says "update the
  README with this branch", "mettre à jour le README avec la branche". Never
  creates a README from scratch; if none exists, tell the user to use
  le-nkang-create-readme.
---

# Le Nkang: update README.md since the last synced commit

Act as a senior Laravel engineer maintaining project documentation. Le Nkang is an adults-only (18+) escort listings directory for Cameroon (Laravel 13 / PHP 8.4, Blade, Tailwind v4, DaisyUI).

This skill updates an existing `README.md`; it never creates one. If `README.md` does not exist, stop and tell the user to run `le-nkang-create-readme` instead. The goal is a surgical, additive README edit, preceded by a docblock audit of the changed source files, so that code documentation and README stay in sync. The README diff must stay small and reviewable: surface only what changed since the README was last synced, without disturbing accurate content.

## 1. Find the baseline: the last synced commit

- Read the end of `README.md` and extract the hash from the `_Last synced with commit <hash> (<date>)_` line. This is the **baseline commit**.
- Validate it:
  - `git cat-file -e <hash>^{commit}` (the commit exists).
  - `git merge-base --is-ancestor <hash> HEAD` (it is part of the current history).
- If the footer is missing, or the hash is unknown or not an ancestor of `HEAD` (squashed, rebased, wrong branch), fall back to the base branch: `git symbolic-ref refs/remotes/origin/HEAD` (fallback `main`), then `git merge-base <base> HEAD` as the baseline. Say clearly in the summary that the fallback was used and why.
- Run `git branch --show-current` to confirm the branch.

## 2. Identify what changed since the baseline

Everything is compared against the baseline commit, so the result covers earlier commits, staged changes, unstaged changes and untracked files in one pass.

- `git log --oneline <baseline>..HEAD` for the commits made since the last sync.
- `git diff <baseline> --name-status -M` for every file that differs between the baseline and the working tree, classified as:
  - `A` added, `M` modified, `D` deleted, `R<score>` renamed (old path to new path), `C` copied.
- `git status --porcelain=v1 -uall` and `git ls-files --others --exclude-standard` for untracked files (new files not yet added), including those inside new folders.
- Read every one of these files, in full, not just the diff hunks:
  - Added, modified and untracked files: open the current content, plus `git diff <baseline> -- <path>` for modified ones to see exactly what changed.
  - Renamed files: note both paths and read the new file; check whether its content also changed.
  - Deleted files: read the removed content with `git show <baseline>:<path>` so you know what functionality, route, class, column or component disappeared.
- Pay particular attention to routes, controllers, requests, models, policies, middleware, migrations, seeders, factories, views/components, config, `.env.example`, `composer.json`/`package.json`, `.ai/` files, tests and anything else that affects the README sections below.
- Record, for each file, its status (added, modified, deleted, renamed) and the real class/method names, middleware aliases and columns it introduces, changes or removes.
- If the baseline equals `HEAD` and the working tree is clean, nothing changed: update only the status footer (step 8) and say so.
- Do not re-audit functionality that existed at the baseline and is already documented. Do not read changes older than the baseline.

Every README edit in steps 4 to 8 must be traceable to a file in this list.

## 2b. Audit docblocks on changed files

Before touching the README, check that the code documentation of every changed file is present, accurate and coherent. The README must describe code whose docblocks are already correct.

**Scope:** files from step 2 with status added (`A`), modified (`M`), renamed (`R`) or untracked, limited to documentable source: `*.php` (app, bootstrap, config, database, routes, tests) and `*.js` in `resources/js`. Skip deleted files, `vendor/`, `node_modules/`, generated or compiled files, and files with no classes, functions or methods (e.g. pure Blade views, `.css`, `.env.example`).

For each file in scope, read it in full and check:

1. **Presence:** every class, trait, method, function and non-trivial property has a docblock, following the existing project style (e.g. a one-line summary, `@param`/`@return`/`@throws` where they add information, `@extends`/`@use` generics where the codebase already uses them, a docblock on every test method).
2. **Accuracy:** each docblock matches what the code actually does now: parameters and their types, return type, thrown exceptions, side effects (events dispatched, DB writes, increments), and conditions. For modified or renamed files, pay extra attention to docblocks of methods whose body changed in `git diff <baseline> -- <path>`: a stale docblock counts as missing.
3. **Coherence:** the wording is consistent with neighbouring files (same language, tense and tone), names the real classes/methods, and has no leftover scaffold text (e.g. "Display a listing of the resource", empty `//` bodies described as if implemented).

Classify each file as **OK** or **needs docblocks**.

**For every file classified as needs docblocks, run `/update-docblocks` on it** (all such files in one invocation if the skill accepts a list, otherwise one per file). Then:

- Re-read each file afterwards and confirm the docblocks now pass the three checks above.
- Verify that only comments changed: `git diff -w <path>` must show no code changes made by this step. If `/update-docblocks` altered behavior, revert that part and report it.
- If `/update-docblocks` is not available, do not write the docblocks by hand silently: list the files that need them in the summary and continue with the README.

Files classified OK are left untouched.

Record the outcome per file (OK, updated, or skipped with reason) for the final summary.

## 3. Preserve exactly

Keep character for character: the `# Le Nkang` heading and tagline, and every section not named in steps 4 to 8 (e.g. Usage, AI tooling, notes). Do not reword preserved text.

Docblock changes (step 2b) never touch code, and never touch files outside the step 2 list.

## 4. "What the app does"

Read the current paragraph.

- If it describes the project accurately, leave it unchanged and append one brief sentence in plain, non-technical terms about what users can now also do because of these changes (skip if nothing user-facing; say so in the summary).
- If it still describes a starter-project domain (e.g. publishing short messages, microblogging, chirps) or says something the changes made false (e.g. "only serves an empty view"), replace that paragraph once with an accurate 2 to 3 sentence description verified against routes/controllers, and flag the correction in the summary.

## 5. Features: add, don't rewrite

Append bullets for the new functionality, matching existing bullet style and specificity (real table/column names, controller/method names, middleware/authorization mechanics). Edit an existing bullet only if these changes made it factually wrong, and then minimally. If a deleted or renamed file made an existing bullet obsolete (e.g. a removed route, controller or table), correct or remove just that bullet.

## 6. Project structure: sync, don't rebuild

In the fenced tree:

- Add entries for added and untracked files/folders (the comment names the real class/file, e.g. `# Escort model`, not `# new model`).
- Remove entries for deleted files.
- For renamed files, replace the old path with the new one and update the comment if the role changed.
- Leave every other line untouched.

## 7. Quick start: clone step check

If the first Quick start instruction is not a `git clone`, insert one as the new first step (use the real remote URL from `git remote get-url origin`, else a placeholder). Otherwise change nothing. Never remove, reorder or reword other commands in Quick start or Manual steps, unless a changed file (e.g. `composer.json` scripts, `.env.example`) makes a documented command or variable factually wrong.

## 8. Status footer

Replace only the hash and date in the existing `_Last synced with commit ... (...)_` line with the current `HEAD` hash (`git rev-parse HEAD`, short or full to match the existing style) and its commit date. Nothing else in that section changes. If the working tree had uncommitted or untracked changes in step 2, mention in the summary that the footer points to `HEAD` and does not include them, so the next run will start from `HEAD` and those changes will still need to be re-read once committed.

Files edited by `/update-docblocks` in step 2b are also uncommitted working-tree changes: mention them in the summary with the same caveat about the footer pointing to `HEAD`.

## Guidelines

- Terse. No filler, no marketing language. GitHub Flavored Markdown, relative links only.
- Never fabricate command names, class names, paths, columns or validation rules; verify each against the files you read in step 2.
- Never document a file you did not read.
- Every README statement about a changed file (class, method, behavior) must be checked against the file as it reads after step 2b; if a docblock and the code disagree, trust the code and fix the docblock, never the other way round.
- If there is nothing README-worthy beyond what's documented, say so and update only the status footer.
- Every edit is additive, or corrective and minimal.
- In the final summary, state the baseline commit used (and whether the fallback applied), list the commits since it, list the changed files with their status (added, modified, deleted, renamed, untracked), then say which README sections were edited because of them.
- In the final summary, also list the docblock audit result per file (OK, updated via `/update-docblocks`, skipped) and say explicitly that these edits are comment-only.
- Do not commit; leave the README and docblock changes in the working tree for review.
