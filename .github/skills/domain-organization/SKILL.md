---
name: domain-organization
description: How to organize and name business-logic code in the Le Nkang Laravel app, by domain (Announcements, and later others), using actions and data transfer objects. Use this skill whenever you create, rename, move or review an action (App\Actions\...), a DTO, a controller method that does more than validate-and-delegate, or when the user asks "where should this class go?", "what should I name this action?", "how do I structure this feature?" or runs make:action. Also use it when adding a feature such as favorites, comments, listings or profiles, even if the user never mentions "domain" or "action".
---

# Domain organization (hybrid)

Le Nkang groups **behaviour** by domain and keeps **everything else** where Laravel puts it. The idea comes from Spatie's "Organise by domain" approach: a domain is just a category of related things (Announcements, Users, ...), and the code that makes a feature work should be easy to find in one place instead of being scattered across a dozen folders.

We use a hybrid, not the full `app/Domain/...` layout. Do not propose moving models, enums or rules into domain folders unless the user asks for that migration.

## Where things go

```
app/
  Actions/<Domain>/<VerbSubject>.php            business operations
  DataTransferObjects/<Domain>/<Subject>Data.php  validated input, structured
  Models/<Model>.php                             flat, Laravel default
  Http/Controllers, Http/Requests, Policies      Laravel defaults
  Events, Listeners, Enums, Rules, Exceptions    Laravel defaults, flat
```

- The domain folder is a plural noun matching the main model: `Announcements`.
- Put a class under the domain that **owns the business rule**. A favorite is something a visitor does to an announcement, so `App\Actions\Announcements\AddAnnouncementToFavorites` is a sensible home. If two domains both plausibly own it, say so and ask rather than guessing.
- Tests mirror this: `tests/Unit/Actions/<Domain>/...` for actions, `tests/Feature/...` for HTTP behaviour.

## Actions

An action is one class that performs one operation inside its domain. Because it does one thing, it can be injected anywhere (controller, console command, listener, another action) and unit tested on its own.

- Scaffold with `php artisan make:action <Domain>/<Name>` so the project stub is used.
- The entry point is `handle()`, matching `stubs/action.stub`. Never `execute()` or `__invoke()`.
- **Name = verb + subject, describing what it does, not where it is called.** `ViewAnnouncement`, `AddAnnouncementToFavorites`, `CreateAnnouncement`. Avoid names that mirror a controller method (`Show`, `Store`): they say nothing about the behaviour, and they collide with imports.
- Never name a class `View`, `Request`, `Response` or anything else that clashes with an Illuminate class the controller already imports.
- One responsibility per action. If a name needs "And", split it. Compose actions by injecting one into another through the constructor.
- Actions may return values. They do not validate input and do not read from `Request`; they receive validated models or DTOs.
- Keep side effects explicit inside the action (increment a counter, dispatch an event) so a reader sees everything the operation does in one file.

```php
namespace App\Actions\Announcements;

use App\Actions\Action;
use App\Models\Announcement;

class ViewAnnouncement extends Action
{
    public function handle(Announcement $announcement): Announcement
    {
        $announcement->loadCount('favorites');
        $announcement->incrementViewsCount();

        return $announcement;
    }
}
```

## Data transfer objects

When an action needs more than one or two pieces of user input, pass a DTO instead of an array. The rule: **if the object exists, it is valid.** Validation happens in the FormRequest; the DTO is a typed mapping of already-validated data, so actions never worry about bad input and tests can build a DTO directly.

- Class name `<Subject>Data` in `App\DataTransferObjects\<Domain>`.
- Use a `readonly` class with constructor property promotion (PHP 8.4 is available) and a named constructor such as `fromRequest()`.

```php
namespace App\DataTransferObjects\Announcements;

use App\Http\Requests\StoreAnnouncementRequest;

readonly class AnnouncementData
{
    public function __construct(
        public string $title,
        public string $description,
    ) {}

    public static function fromRequest(StoreAnnouncementRequest $request): self
    {
        return new self(
            title: $request->validated('title'),
            description: $request->validated('description'),
        );
    }
}
```

## Controllers stay thin

Almost every controller method follows three steps: validate and build a DTO, run the action, return the result. If a controller method has business rules in it, extract an action.

```php
public function store(StoreAnnouncementRequest $request, CreateAnnouncement $action): RedirectResponse
{
    $announcement = $action->handle(AnnouncementData::fromRequest($request));

    return to_route('announcements.show', $announcement);
}
```

## Project conventions that apply here

- User-facing vocabulary is "favorite" (not "like") for announcements, including in test names and column or relation names.
- Test methods are camelCase and prefixed with `test` (`testGuestUserCanViewAnAnnouncement`), which is what Pint is configured to enforce.
- Run `vendor/bin/pint` on files you create or change.

## Quick checks before finishing

1. Does each action name say what it does, and is it free of controller-method words?
2. Does `handle()` receive models or DTOs rather than a `Request` or a raw array?
3. Is the controller method only validate, delegate, return?
4. Is the class in the folder of the domain that owns the rule, with tests alongside?
5. Did you leave models, enums, rules and exceptions in their Laravel default folders?
