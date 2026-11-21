---
name: value-objects
description: How to make impossible states impossible in the Le Nkang Laravel app by promoting primitives (int, float, string) with rules into small immutable value objects, with Eloquent casts and a clear home for each class. Use this skill whenever you see a guard clause or validation that contradicts a broad type hint (a method takes int/float/string and then throws or returns early if it is negative, empty, out of range or not a UUID), when adding a field with rules such as a rating (note), a price in FCFA, a phone number, a slug, a count or a percentage, when writing a custom cast, or when the user asks "should this be its own class?", "where should this value object go?" or "how do I stop invalid values?". Use it even if the user never says "value object" or "type safety".
---


# Value objects: make impossible states impossible

Idea (from Kai Novski's talk on using the type system): if a parameter must satisfy rules a plain `int`, `float` or `string` does not, the parameter is not really that primitive. It is a domain concept that has not been named yet. Give it a class, enforce the rules in the constructor, and invalid values can no longer exist anywhere the type is accepted.

## The smell to look for

A broad type followed by a check that contradicts it:

```php
public function wait(int $seconds): void
{
    if ($seconds < 0) {
        throw new InvalidArgumentException('...');
    }
}
```

The guard fixes the symptom. The call `wait(-5)` is still valid PHP and a static analyser cannot see anything wrong. The root cause is that the parameter is not an `int`, it is a `Duration`.

Typical Le Nkang candidates: a review `note` that must be 1 to 5, a price in FCFA that must be positive, a phone number used in `wa.me` and `tel:` links, a discount percentage, a slug, a views or favorites count that must never be negative.

## When to extract, and when not to

Extract when at least one of these is true:

- The same rule is checked, or should be checked, in more than one place for the same kind of data.
- The concept has a name the business uses (a `Rating`, a `Price`, a `PhoneNumber`).
- Two values share a primitive type but must never be mixed up (the talk's user UUID vs device UUID).

Do **not** extract when the rule appears in exactly one place and the concept carries no meaning. An inline guard is fine there. Do not create a class for every string or number: `FirstName`, `FavoriteFruit` and similar are over-engineering. If unsure, say which of the three conditions applies and let the user decide.

## Shape of a value object

- `final readonly class`, a single promoted property, validation in the constructor so an instance is always valid.
- Throw `InvalidArgumentException` with a helpful message.
- Add named constructors that remove unit or scale ambiguity (`Duration::seconds(5)`, `Discount::percentOff(25)`), and keep the internal representation convenient for maths.
- Expose behaviour that belongs to the concept (formatting, comparison, conversion) rather than a public getter for everything.
- Add `equals()` when value comparison matters, since `==` on objects compares properties and `===` compares identity.

```php
namespace App\ValueObjects\Reviews;

use InvalidArgumentException;

final readonly class Rating
{
    public function __construct(public int $value)
    {
        if ($value < 1 || $value > 5) {
            throw new InvalidArgumentException("A rating must be between 1 and 5, got {$value}.");
        }
    }

    public static function stars(int $count): self
    {
        return new self($count);
    }
}
```

Then narrow the signature and delete the guard that used to live in the caller:

```php
public function handle(Announcement $announcement, Rating $rating): Review
```

Never validate a value object a second time downstream. The type is the guarantee.

## Where they live

This follows the hybrid layout in the `domain-organization` skill: behaviour is grouped by domain, Laravel defaults are kept for everything else.

```
app/
  ValueObjects/<Domain>/<Concept>.php   owned by one domain: Reviews\Rating
  ValueObjects/<Concept>.php            shared by several domains: Price, PhoneNumber
  Casts/<Concept>Cast.php               Laravel default folder, flat
```

- Put a value object under the domain that **owns the business rule**. A rating belongs to Reviews. Move it up to the root of `ValueObjects` only when a second domain genuinely needs it, not in advance.
- Class name is the concept, not a technical suffix: `Rating`, not `RatingValueObject`.
- Casts stay in `App\Casts` regardless of domain. If two domains both plausibly own a value object, say so and ask instead of guessing.
- Tests: `tests/Unit/ValueObjects/<Domain>/<Concept>Test.php`. Cover a valid value, each invalid boundary and the named constructors. Test methods are camelCase and prefixed with `test`, as Pint enforces here.

## Eloquent casts

When a model attribute is the primitive, a custom cast turns it into the value object on read and back to a primitive on write, so the type hints are true all the way from the database.

```bash
php artisan make:cast RatingCast
```

```php
namespace App\Casts;

use App\ValueObjects\Reviews\Rating;
use Illuminate\Contracts\Database\Eloquent\CastsAttributes;
use Illuminate\Database\Eloquent\Model;
use InvalidArgumentException;

/** @implements CastsAttributes<Rating, Rating|int> */
class RatingCast implements CastsAttributes
{
    public function get(Model $model, string $key, mixed $value, array $attributes): ?Rating
    {
        return $value === null ? null : new Rating((int) $value);
    }

    public function set(Model $model, string $key, mixed $value, array $attributes): ?int
    {
        return match (true) {
            $value === null => null,
            $value instanceof Rating => $value->value,
            is_int($value) => (new Rating($value))->value,
            default => throw new InvalidArgumentException('The note must be a Rating or an integer.'),
        };
    }
}
```

```php
// App\Models\Review
protected function casts(): array
{
    return ['note' => RatingCast::class];
}
```

Rules:

- Never fake the type by only editing the docblock to say `Rating`. The attribute must actually return one, via the cast.
- `get` and `set` must round-trip. Assert it in a feature or unit test.
- Do not add a cast when the value is never used in typed code. A cast earns its place when signatures accept the value object.
- When two attributes share a primitive but not a meaning (user `uuid` vs a device or announcement id), give them different classes and casts so they cannot be swapped.
- Factories should produce valid values (`'note' => fake()->numberBetween(1, 5)`), since the cast now rejects bad ones.

## Workflow

1. Spot the smell: a broad type contradicted by a guard, or a repeated rule on the same kind of data.
2. Name the concept in the user's domain vocabulary (French UI terms stay in views, class names in English, "favorite" not "like").
3. Decide extract or inline using the three conditions above, and say why.
4. Create the value object in the right folder, move the guard into its constructor, add named constructors if units or scale are ambiguous.
5. Narrow signatures to the new type and delete the now-redundant guards.
6. Add a cast if the value comes from a model attribute.
7. Add tests, update factories, run `vendor/bin/pint`.

## Quick checks before finishing

1. Is it impossible to construct the object in an invalid state, with no setters or public mutation?
2. Is every old guard clause for this rule gone from callers?
3. Does the class sit in the domain that owns the rule (or the shared root with a reason)?
4. Does the cast return the real type, and does it round-trip?
5. Did you resist extracting a class for a one-off rule with no domain meaning?
