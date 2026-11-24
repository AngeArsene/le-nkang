---
name: role-playing-objects
description: Replace growing conditionals with polymorphic role-playing objects, based on Sandi Metz's "Death Star" talk. Use this skill whenever the user is about to add or review an `if`/`elseif`/`match`/`switch` that picks behavior from a flag, type, tier, channel, status or option array, has a class or action that keeps accumulating branches ("ça grossit à chaque changement", "trop de if"), has a Laravel action/controller/model method with many execution paths and incomplete tests, asks "should this be a strategy / its own class?", how to inject smarter dependencies, or where a factory belongs. Trigger even if the user never says "polymorphism" or "role" — e.g. "add a new tier to the pricing logic", "refactor this method full of conditionals", "pourquoi ma classe devient ingérable ?". Complements `oop-affordances` (where a method lives) and `domain-organization` (where the class lives).
---

# Role-playing objects (killing the Death Star)

## The problem

Every app has a **Death Star**: a class that is bigger than average, full of conditionals, under-tested, feared, and central to the domain. It forms because we start with a simple procedure (right at the time), then each change "doubles down" on what worked: one more `if`. Execution paths multiply (the Cartesian product of the conditionals: 2 → 4 → 8 → 16), tests can't keep up, and past a certain complexity nobody can refactor it.

Two lessons to remember:
- **Easy is not simple.** Adding one more branch is easy; the result is not simple.
- **What made you succeed will eventually doom you.** Past the inflection point, stop adding branches and design.

Hiding a conditional behind a private method is not a fix: it only looks better. A condition that picks behavior is a missing object.

## Detecting it (churn × complexity)

Flag a class when it is complex **and** changes often (many commits, many branches, no full test coverage), and when it sits in the middle of the domain (Announcement, Review, pricing, contact…). Complex-but-stable code can wait; complex-and-churning code is the target.

## Procedure

Do one conditional at a time. Each step halves the execution paths and must keep tests green.

1. **Find the variation.** What differs between the branches? ("where the lines come from", "how the price is computed", "which channel is used".)
2. **Name the role.** This is the hard part. Pick a noun for the role (`Source`, `Subset`, `Justifier`; here: `PricingRule`, `ContactChannel`) and **one message** all players answer (`lines`, `price`, `link`). If you cannot name it, you do not understand the abstraction yet.
3. **Make one player per branch.** Move each branch body into its own small class implementing that message. Include the "everything / nothing" case as a legitimate player (an `AllLines`, a `NoDiscount`): treating the default as a real object removes the `if`.
4. **Inject the role, not the flags.** The collaborator receives a `PricingRule`, not `$tier` + `$options`. "Inject smarter things": dependency injection of raw data just moves the `if`.
5. **Push the choice back into a factory.** The one place that knows which player to pick holds the conditional (`for($announcement)`, `from($request)`). Keep it small, simple, and in a single place; do not build a pattern-book factory. Everything else just sends the message.
6. **Collapse the original.** What remains only orchestrates collaborators: no conditionals about *which* behavior.
7. **Test:** one small test per player (single path), plus tests for the factory's choice. Before step 3, add characterization tests if coverage is poor.

If a conditional cannot be injected because it depends on data iterated inside the method, extract the players first (half step: call them explicitly from the branches), then move the choice into a factory.

## Laravel shape

Follow the project's conventions: group by domain (`App\Actions\Announcements\...`, see `domain-organization`), actions expose `handle()`, primitives with rules become value objects (see `value-objects`). Players can be small invokable classes or implementations of an interface in the domain namespace; the factory can be a static `for()` / `from()` method on the interface or a dedicated class resolved from the container. Use an enum with a method (`Tier::pricing()`) only when the variation is a single value, not behavior.

## Guardrails

- Don't do this for one stable `if`. The first branch is fine; abstract when the second or third variation shows up, or when churn and complexity both rise.
- Don't wrap a messy procedure in indirection without understanding it ("faux OO"): if roles don't have meaningful names, you're only adding layers.
- Accept the trade-off and say so: more small parts, easier to change any part, harder to see the whole in one file. Trustworthy objects that honor their role make that fine.
- One conditional per step, behavior unchanged.

## Output format

When reviewing: name the Death Star signals found, the role and its one-message API, the players, the factory (where the remaining `if` lives), and before/after execution-path counts. Provide code in small steps. Reply in the user's language; code identifiers in English.
