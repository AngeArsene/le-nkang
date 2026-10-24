---
name: tdd-laravel
description: Outside-in test-driven development workflow for Laravel/PHP applications (acceptance tests first, then unit tests, "programming by wishful thinking", fakes over mocks). Use this skill whenever the user wants to build or add a Laravel feature test-first, write feature/acceptance or unit tests for a Laravel app, practice TDD or "red-green-refactor" in PHP, decide between a mock, fake, or spy (Mail, Event, Queue, Notification), speed up a PHPUnit/Pest suite, or says things like "TDD Laravel", "écrire les tests d'abord", "tester l'envoi d'un email", "test de fonctionnalité". Trigger even if the user doesn't say "TDD" but is writing tests for a new Laravel feature.
---

# Test-Driven Laravel (outside-in TDD)

Workflow adapted from Adam Wathan's "Test-Driven Laravel" talk. The goal: drive a feature out of failing tests only, letting each error message dictate the next line of code.

Read `references/modern-laravel.md` when the project is Laravel 8+ (the talk used 5.3: class-based factories, `RefreshDatabase`, `Mail::fake()`, `Event::fake()`, Pest all replace older idioms).

## The two loops

**Outer loop (acceptance / feature test):** write a failing test from the end user's point of view, black-box (HTTP request in, visible result out).
**Inner loop (unit test):** when the outer test fails with an error too far from the code you need to write (or the failure message isn't useful), drop down and drive out the missing component with a unit test. Return to the outer test once the unit is green.

Then refactor with all tests green, and move on to the next failing acceptance test.

## Procedure

1. **Pick the first test: a "walking skeleton".** On a brand-new app, choose the feature that cuts through the whole stack (route → controller → DB → view) with the least incidental complexity. Prefer something core to the app's purpose that avoids auth/registration (e.g. "view another user's tweets" before "post a tweet"). Write down the candidate features, cross out those needing auth or setup unrelated to the app's core, pick what's left.
2. **Organize tests:** `tests/Feature/` for acceptance tests, `tests/Unit/` for single components (mirror the `app/` structure inside Unit, e.g. `tests/Unit/Listeners/`). Keep it that simple.
3. **Sketch the test as comments first** (Arrange / Act / Assert), then fill in code one line at a time.
4. **Programming by wishful thinking:** write the code you wish existed (classes, methods, routes, views) before they exist. Run the test, read the error, make the smallest change that fixes *that* error, rerun. Never write code that no failing test is asking for (e.g. don't add a 141-char DB constraint until a test requires it).
5. **Run the tests after every small change** while learning the workflow; skip runs only once you can predict the errors reliably.
6. **Use direct model access for setup** in acceptance tests: create the data with factories rather than clicking through registration/login flows. Faster and isolated from unrelated features.
   - `create()` persists; `make()` builds in memory. Prefer `make()` + relationship `save()` over setting foreign keys by hand, to avoid leaking column names across tests.
7. **Test database:** in-memory SQLite via `phpunit.xml` env (`DB_CONNECTION=sqlite`, `DB_DATABASE=:memory:`) + a trait that migrates per test. Outgrow it only when needed.
8. **Don't put logic in route closures or controllers when a more expressive method exists.** Example: controller calls `User::findByUsername($name)`; then a unit test drives that method out. Name things after intent, not after query chains.
9. **Refactor towards the design you want** (e.g. inline `Mail::send` → fire an event → listener sends the mail). A black-box acceptance test survives implementation changes; that's the point.
10. **Wire-up check:** after driving out a listener/service with unit tests, rerun the acceptance test. If it fails, something isn't wired (event→listener mapping, container binding, type-hint). This is what acceptance tests are for.

## Mocks, fakes, spies

- **Avoid mocking the exact implementation** (e.g. `Mail::shouldReceive('send')->with(...)` plus closure matchers). Such tests are written after the code, mirror it line by line, pass even when the recipient is wrong, and break on harmless reorderings or refactors.
- **Prefer a fake that you assert against by outcome:** "the followed user received an email", "it contains the follower's name", "subject contains 'new follower'". Express expectations as outcomes before writing the implementation.
- **Assert on the most stable thing:** `assertStringContainsString('new follower', $subject)` rather than the full subject string that design/copy changes will break.
- **When a mock is justified** (verifying that an event was fired with the right payload, so the acceptance test doesn't duplicate the listener's unit test): compare by identity of data (e.g. IDs), not object instances; and prefer a **spy** (`Mockery::spy` / `Event::spy()`) so assertions (`shouldHaveReceived`) stay in the Assert phase at the end of the test, keeping Arrange/Act/Assert consistent and removing the need for `shouldIgnoreMissing`.
- **Avoid redundant coverage:** once the listener's unit test checks that mail is sent, the acceptance test can just verify that the event is fired (with correct arguments, in the right order).

## Speed

- Acceptance tests are slow; combine assertions where it doesn't hurt clarity, and push detail down to unit tests.
- In unit tests that don't read from the DB, use `make()` instead of `create()` and drop the migration trait; the test runs without a database. Trade-off: the test is now coupled to "no DB needed" and breaks if the implementation starts to depend on it.

## Output expectations

When helping a user:
- Show the **failing test first**, the **exact error** expected, then the **minimal code** to fix it. One red→green step at a time unless the user asks to go faster.
- Name tests descriptively and at length (`test_users_are_sent_a_notification_when_followed`).
- Match the project's Laravel/PHPUnit/Pest version; check `composer.json` before choosing syntax.
- Reply in the user's language; keep code identifiers in English.
