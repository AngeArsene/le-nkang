---
name: oop-affordances
description: Object design guidance based on "methods as affordances, not abilities" (Adam Wathan's talk). Use this skill whenever the user is designing or refactoring classes in PHP/Laravel (or any OOP language), asks where a method should live, has classes named like "SomethingService", "Manager", "Handler", "Broadcaster", "Fulfiller" or any "doer"/agent-noun class, has a bloated User model or "god object", wants to extract logic out of a fat controller, or asks how to name event listeners or make non-deterministic code testable. Trigger even if the user never mentions "affordances" — e.g. "où mettre cette méthode ?", "refactorer ce service", "ma classe User est trop grosse", "extraire la logique du contrôleur".
---

# Methods as affordances (not abilities)

## Core idea

Most people design by asking "what *can do* this thing?" and invent an object to do it (`Gardener::water($plant)`). Look at built-in APIs instead: `array.reverse()`, `string.split(',')`, `$date->format('l')`. The array does not reverse things; **it can be reversed**. A method on an object tells you **what can be done *with* that object**, like a drawer handle signals "pull me".

**Test sentence:** translate the call into English as "*An <object> can be <method> using <parameters>*".
- `$names->reverse()` → "an array can be reversed" ✅
- `$string->split($delim)` → "a string can be split using a delimiter" ✅
- `$gardener->water($plant)` → "a gardener can be watered using a plant" ❌ → the gardener vanishes: `$plant->water()`.

If the sentence is nonsense, the method is on the wrong object (or the object shouldn't exist).

"A user can't save itself" is a straw man: `$user->save()` just says a user (a DB record) can be saved.

## Procedure when reviewing or writing code

1. For each doer-style call `$thingDoer->doIt($x)`, ask: "what am I really doing, and **to what**?" The thing acted on (`$x`) is the candidate home of the method.
2. Move the method onto `$x` (drop the now-redundant parameter, replace `$x->` with `$this->`).
3. Resolve any dependency the method needs (mailer, dispatcher, payment gateway) with one of the options below.
4. Delete the old doer class if it's empty.
5. Run the tests; behavior must not change.

## Five benefits (and what to do for each)

### 1. Eliminate agent nouns

`AnnouncementBroadcaster::broadcast($announcement)` → `$announcement->broadcast()`.
`PurchaseFulfillmentService::fulfill($purchase)` → `$purchase->fulfill()`. A "Service" suffix is usually a doer class in disguise.
Bonus: **encapsulation.** The model updates its own fields (`broadcast_at`), so knowledge of its columns stops leaking outward.

### 2. Handle dependencies of the moved method

Choose, in order of the author's preference for ergonomics:
- **Facade / container resolution** inside the method (e.g. `BroadcastAnnouncement::dispatch($this)`). Acceptable: PHP already relies on global state (e.g. the time-zone database behind `DateTime`), and API ergonomics matter. Global access to a per-environment singleton is a fair trade.
- **Method injection** (`$checkout->complete($paymentGateway, $token)`): best when you want polymorphism (Stripe vs PayPal) or no container coupling.
- **Push side work to an event + listener** when the work is ancillary (sending the confirmation email after `fulfill()`): `PurchaseFulfilled::dispatch($this)`. The listener injects the mailer via its constructor.

### 3. Name event listeners as actions, not nouns

`SendPurchaseFulfillmentEmail`, not `PurchaseFulfilledListener`. The name states what it does in response to the event.

### 4. Break up god objects

`User` accumulates methods because "users can do stuff". Ask what the method acts on: `$user->redeemLicense($license)` → `$license->redeem($user)`. Models that were bags of columns gain real behavior, and `User` shrinks. Fire a domain event (`LicenseRedeemed`) for ancillary work (e.g. granting repo access).

### 5. Discover new concepts

Controller actions have four parts: fetch, validate, do the thing, respond. If "do the thing" is large (charge, create purchase, fulfill), ask "what is being *done*, and to what?" and find the noun that answers it. Example: `new Checkout($product, $email)` then `$checkout->complete($gateway, $token)` returns the `Purchase`. This is a different object than the doer-mindset would have produced (`PurchaseCreator`).

## Sometimes you just need a function

For non-deterministic or swappable logic (e.g. random license codes) that tests must stub: don't create `LicenseCodeGenerator::generateLicenseCode()`. Be honest and make it a function:
- An **invokable class** (`GenerateLicenseCode::__invoke()`) bound/resolvable in the container, or a closure bound under a name, so tests can swap it.
- Optionally hide the container behind a static helper (`LicenseCode::generate()` resolving and invoking the function) for expressive call sites.

## Guardrails

- This is not "never write a class ending in -er". Doer classes are a **last resort, not the first reflex**; try the affordance reading first.
- Don't force it where the sentence test genuinely holds for a collaborator (e.g. `$gateway->charge($amount)`).
- Preserve behavior and keep tests green at each move. If tests don't exist, suggest writing one first (see `tdd-laravel` skill if available).

## Output format

When reviewing code: list each smell, show before/after snippets, state the test sentence that justifies the move, and mention how dependencies are handled. Reply in the user's language; code identifiers stay in English.
