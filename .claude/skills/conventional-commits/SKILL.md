---
name: conventional-commits
description: Write, review, fix, or validate git commit messages following the Conventional Commits 1.0.0 specification (type, scope, description, body, footers, BREAKING CHANGE). Use this skill whenever the user asks for a commit message, wants to review or rewrite commits, asks how to split changes into commits, sets up commitlint/changelog/semantic-release/semver automation, or mentions "commit message", "message de commit", "git commit", "feat/fix/chore", "changelog" or "BREAKING CHANGE" — even if they don't name the spec. Also use when summarizing a diff or staged changes into a commit.
---

# Conventional Commits 1.0.0

## Format

```
<type>[optional scope][!]: <description>

[optional body]

[optional footer(s)]
```

## Types and SemVer mapping

| Type | Use for | SemVer |
|---|---|---|
| `fix` | bug fix | PATCH |
| `feat` | new feature | MINOR |
| any type with `!` or a `BREAKING CHANGE:` footer | breaking API change | MAJOR |
| `build`, `chore`, `ci`, `docs`, `style`, `refactor`, `perf`, `test`, `revert` | everything else (the common @commitlint/config-conventional / Angular set; not mandated by the spec) | none |

## Rules (condensed from the spec)

1. Prefix = type (noun), optional `(scope)`, optional `!`, then mandatory `: ` (colon + space).
2. `feat` for new features, `fix` for bug fixes.
3. Scope = a noun in parentheses naming a codebase section: `fix(parser): ...`.
4. Description follows immediately after the colon+space; short summary of the change (imperative, lowercase, no trailing period is the common style).
5. Body is optional, starts **one blank line** after the description, free-form, any number of paragraphs.
6. Footers start one blank line after the body. Format `Token: value` or `Token #value` (git-trailer style). Tokens use `-` instead of spaces (`Reviewed-by`, `Refs`), except `BREAKING CHANGE`. A footer value can span lines; it ends when the next valid token/separator appears.
7. Breaking changes: either `!` right before the colon (`feat(api)!: ...`, then the description describes the break and the footer may be omitted), or a footer `BREAKING CHANGE: <description>` (uppercase; `BREAKING-CHANGE` is a synonym). Both may be combined. Any type can be breaking.
8. Everything is case-insensitive except `BREAKING CHANGE`, which must be uppercase. Be consistent anyway (lowercase types).

## Examples

```
feat(lang): add Polish language
docs: correct spelling of CHANGELOG
feat(api)!: send an email to the customer when a product is shipped
feat: allow provided config object to extend other configs

BREAKING CHANGE: `extends` key in config file is now used for extending other config files
fix: prevent racing of requests

Introduce a request id and a reference to latest request. Dismiss
incoming responses other than from latest request.

Reviewed-by: Z
Refs: #123
revert: let us never again speak of the noodle incident

Refs: 676104e, a215868
```
(Each block above is a separate commit message.)

## Procedure when asked to write a commit message

1. Inspect the change (`git diff --staged`, or what the user pasted).
2. If the change mixes several types/concerns (e.g. a feature plus a bug fix plus refactor), **recommend splitting into multiple commits** and give one message per commit.
3. Choose the type by intent, not by file touched; add a scope only if it adds clarity and matches the project's existing scopes (check `git log` / commitlint config if available).
4. Write a concise description (aim ≤ 72 chars on the first line); put the "why" in the body; add `Refs: #id`, `Closes #id`, etc. in footers when an issue is mentioned.
5. Flag breaking changes with `!` and/or `BREAKING CHANGE:` explaining what breaks and the migration.
6. Return the message in a code block, ready to paste. Offer `git commit -m "..." -m "..."` form only if asked.

## Reviewing / fixing existing commits

- Point out violations (missing colon-space, wrong casing of `BREAKING CHANGE`, body without blank line, wrong type) and give the corrected message.
- Wrong type before merge/release: `git rebase -i` to reword. After release, cleanup depends on tooling. A non-conforming commit just gets ignored by spec-based tools, not a disaster.
- Contributors don't all need to comply: with a squash-merge workflow, the maintainer writes the conventional message at merge time.

## Tooling pointers (offer when relevant)

- Enforcement: commitlint with `@commitlint/config-conventional`, plus Husky or lefthook `commit-msg` hook.
- Automation: changelog generation, automatic version bumps, release pipelines (e.g. semantic-release, release-please, standard-version) driven by `feat`/`fix`/breaking commits.
- Early development: act as if already released; someone is consuming your software.

## Output

Reply in the user's language; keep the commit message itself in the language the project uses (default English). Keep answers short: the message(s) first, a one-line justification after.
