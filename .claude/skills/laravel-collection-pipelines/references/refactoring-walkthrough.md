# Step-by-step refactoring walkthrough

Read this when you need to show *how* a nested loop becomes a pipeline, or when the loop is more tangled than the table in SKILL.md covers.

## Contents

1. map and filter derived from a loop
2. Blocked map: filter first
3. The full Amsterdam sales refactoring
4. reduce, and why sum exists
5. contains / first with lazy default

## 1. map and filter derived from a loop

Two loops that differ in one line:

```php
$emails = [];
foreach ($customers as $customer) { $emails[] = $customer->email; }

$totals = [];
foreach ($items as $item) { $totals[] = ['name' => $item->name, 'total' => $item->qty * $item->price]; }
```

Everything except the transformation is identical. Extract the difference into a callback and wrap the rest in a function and you have `array_map` / `->map()`. The same move on "push only if condition holds" gives `filter`. The point: a loop that matches one of these shapes is a hand-written named operation, so use the named one.

## 2. Blocked map: filter first

```php
$emails = [];
foreach ($employees as $employee) {
    if ($employee->department === 'sales') { $emails[] = $employee->email; }
}
```

`map` alone would include every employee. Flip the thought: "I could use `map` if I only had sales employees." So:

```php
$emails = $employees
    ->filter(fn ($e) => $e->department === 'sales')
    ->map(fn ($e) => $e->email);   // or ->pluck('email')
```

## 3. The full Amsterdam sales refactoring

Start from the nested version in SKILL.md and apply one change at a time, checking the result after each:

1. **Filter employees** to Amsterdam. The `if` disappears and everything un-indents one level.
2. **Get one list of customers.** Mapping employees to customers yields a collection of collections; flatten one level. Because this pair is so common, use `flatMap`.
3. **Map customers to totals.** First copy the inner loop into the callback so it works, then simplify it:
   - map orders to their totals, then reduce to a single value,
   - replace the `reduce` with `sum`,
   - replace `map(fn ($o) => $o->total)` with `pluck('total')`,
   - replace `pluck('total')->sum()` with `sum('total')`.
4. **Filter customer totals** by the threshold; the last conditional disappears.
5. **Sum** what remains.
6. **Inline temporaries** one by one (each is used once) and inline the threshold into the closure or a constant.

Result: one chain, no loops, no conditionals, no temporary variables, at most one level of indentation.

## 4. reduce, and why sum exists

```php
$totalOrderValue = $orderTotals->reduce(
    fn ($carry, $orderTotal) => $carry + $orderTotal,
    0
);
```

`reduce` folds a list into one value: the callback receives the accumulated value so far and the next item, and returns the new accumulated value; the second argument is the starting value. Adding things up is so common that `sum()` exists. Reach for `reduce` only when no named operation says what you mean.

## 5. contains / first with lazy default

Before:

```php
foreach ($supportedVersions as $version) {
    if ($this->installed($version)) { return true; }
}
return false;
```

After: `return $supportedVersions->contains(fn ($v) => $this->installed($v));`

Finding the first match or failing:

```php
return $this->supportedVersions()->first(
    fn ($version) => str_contains($resolvedPath, $version),
    fn () => throw new DomainException('Unable to determine linked PHP.')
);
```

The default is only evaluated when nothing matches, so it can be expensive (a query) or throw. This removes the `null` check and the temporary variable.

Extract repeated lists (e.g. the supported versions) into a small helper method returning a collection so each caller expresses intent in one line.
