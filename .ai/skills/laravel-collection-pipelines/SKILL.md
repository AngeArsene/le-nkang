---
name: laravel-collection-pipelines
description: How to refactor loops, nested conditionals and temporary variables into expressive Laravel collection pipelines (map, filter, flatMap, pluck, reduce, sum, contains, first, groupBy, partition). Use this skill whenever you write or review PHP/Laravel code that builds an array inside a foreach, accumulates a total in a variable, nests foreach loops, has an if inside a loop that decides what gets collected, searches a list with a loop or in_array, or when the user asks to "clean up this loop", "refactor to collections", "make this more functional/readable", "remove temporary variables", or asks how to use Collection methods. Use it even if the user never says "collection" or "pipeline", and also when writing new code that transforms lists of models or arrays.
---

# Laravel Collection Pipelines

Replace "initialize, loop, mutate, return" code with a chain of small, named operations. Each step does one thing, has no shared state, and can be understood on its own. The goal is readability and maintainability, not cleverness or speed.

## The core idea

Most loops are one of a few operations written by hand. Recognising which one is the whole skill:

| The loop does this | Use |
|---|---|
| Starts with `[]`, pushes a transformed item for every input | `map` (or `pluck` if it only extracts one field) |
| Starts with `[]`, pushes the item itself only if a condition holds | `filter` (or `reject` for the inverse) |
| Starts with `0`/`[]`, folds every item into one value | `sum`, `avg`, `max`, `count`, otherwise `reduce` |
| Loops inside a loop to produce one flat list | `flatMap` (`map` then `flatten(1)`) |
| Loops to see if any item matches, then returns true/false | `contains(fn)` (or `some`/`every`) |
| Loops to find the first match, returns it or fails | `first(fn, default)` |
| Pushes into buckets keyed by something | `groupBy`, `keyBy`, `partition` |

## The method: break it into independent steps

When a loop does not fit one operation (typically `map` blocked by an `if`), do not force it. Ask: "What would let me use the simple operation?"

1. If a conditional blocks `map`: "I could use `map` if I only had the matching items." Add a `filter` first, then `map` the result.
2. If nesting buries the logic: "This would be flat if I had one big list." Add a `flatMap` to get that list, then work on it.
3. If an inner loop computes a per-item total: `map` each item to its total first, then process the list of totals.
4. After each step, the loop below it usually becomes simpler or disappears. Delete what became redundant.
5. Once every step is a collection call and a variable is only used once, **inline it** so the steps read top to bottom as one chain.
6. Verify after every small step (run the tests, or compare the result with the original). Never rewrite everything at once.

Why chaining beats nested function calls: `array_map(fn..., array_filter($x, fn...))` reads inside-out and backwards. `$x->filter(...)->map(...)` reads in the order things happen.

## Worked example (condensed)

Before: nested loops, conditionals, three temporary variables.

```php
$total = 0;
foreach ($employees as $employee) {
    if ($employee->district === 'Amsterdam') {
        foreach ($employee->customers as $customer) {
            $customerTotal = 0;
            foreach ($customer->orders as $order) {
                $customerTotal += $order->total;
            }
            if ($customerTotal >= $minSales) {
                $total += $customerTotal;
            }
        }
    }
}
return $total;
```

After:

```php
return $employees
    ->filter(fn ($employee) => $employee->district === 'Amsterdam')
    ->flatMap(fn ($employee) => $employee->customers)
    ->map(fn ($customer) => $customer->orders->sum('total'))
    ->filter(fn ($customerTotal) => $customerTotal >= $minSales)
    ->sum();
```

Notice the intermediate shapes: employees → Amsterdam employees → customers → numbers → big numbers → one number. Each line has a single reason to change. See `references/refactoring-walkthrough.md` for the step-by-step derivation, including `reduce` from first principles.

## Handy shortcuts (prefer the shorter form)

- `map(fn ($x) => $x->email)` → `pluck('email')`
- `map` + `sum` of a field → `sum('total')` or `sum(fn ($o) => $o->price * $o->qty)`
- `map` then `flatten(1)` → `flatMap`
- loop + `in_array` / flag variable → `contains($value)` or `contains(fn ($v) => ...)`
- loop to find first match, else throw → `first(fn ($v) => ..., fn () => throw new DomainException('...'))`. The default can be a closure, which is lazily evaluated, and on PHP 8 it can throw.
- `filter` then `count` → `->filter(...)->count()` or `->countBy(...)` for tallies
- split into two lists → `[$a, $b] = $items->partition(fn ($i) => ...)`
- higher-order messages for trivial callbacks: `$users->map->fullName()`, `$users->filter->isActive()`
- re-index after filtering when you need a list again (e.g. before `json_encode`): `->values()`

## Modern Laravel notes

Earlier versions (5.2 and below) passed `($key, $value)` to `contains` and `first` callbacks, which led to `fn($_, $value)` workarounds. Current Laravel passes `($value, $key)`, so just write `fn ($value) => ...`. Arrow functions (`fn`) capture outer variables automatically, so use them instead of `function () use ($x)` unless you need to mutate by reference. Wrap plain arrays with `collect($array)`; Eloquent and query-builder `get()` already return collections.

## When not to use a collection

- **Large data sets belong in the database.** If you would load thousands of rows only to filter or sum them, use a `where`, `sum()` or `groupBy` query instead. Collection pipelines are for in-memory shaping and for small lists, where the value is expressiveness rather than performance.
- Do not chain for its own sake. If a plain `foreach` with a single early `return` is clearer, leave it.
- Avoid `reduce` when a named operation (`sum`, `max`, `groupBy`) already says what you mean.
- A callback that grows past ~3 lines deserves a named method on the model or a small class; the pipeline should stay a readable outline.
- Don't mutate outer variables inside a callback; that reintroduces the shared state you were removing.

## Output format when refactoring for a user

1. Show the final pipeline.
2. Say in one or two sentences which loop smell each step replaced (so the user can spot the pattern next time).
3. Mention any behaviour difference (e.g. `filter` preserves keys, so add `values()` if the caller expects a list).
4. If the dataset could be large or comes from Eloquent, point out the database alternative.
