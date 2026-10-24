---
name: cruddy-controllers
description: Laravel/Rails controller design using the "Cruddy by Design" approach (Adam Wathan, Laracon 2017) - never write custom controller actions, only the 7 standard REST/CRUD actions, and split big controllers into many small resource controllers. Use this skill whenever the user has a bloated controller, asks how to organize routes/controllers or name a controller, has custom actions like subscribe/publish/archive/updateCoverImage, asks how to model nested resources, pivot tables or state changes RESTfully, or is tempted to add service objects, form requests, or a command bus just to shrink a controller. Trigger even if the user doesn't mention CRUD, e.g. "mon contrôleur a trop de méthodes", "où mettre cette action", "comment nommer ce contrôleur", "refactorer mes routes".
---

# Cruddy by Design

Core idea: Basecamp 3 had ~206 controllers out of ~450 classes, averaging ~4 methods each. Instead of extracting service objects, command buses or form requests to shrink a fat controller, **cut it into more controllers**. Most of the time nothing more sophisticated is needed.

## The NWCA rule: Never Write Custom Actions

Only these seven actions are allowed on any controller: `index, create, store, show, edit, update, destroy`. Anything else (`listEpisodes`, `updateCoverImage`, `subscribe`, `publish`...) is a custom action to be remodeled. This also caps any controller at 7 actions; in practice most need 2-3.

## Procedure

1. List the controller's routes/actions. Draw a line between the 7 standard ones and the custom ones.
2. For each custom action, ask which of the 7 fits (see patterns below), name the **resource** it really acts on, create a new controller for it, move the action, rename it to the standard action, and adapt the route (let the **HTTP verb** carry the meaning; drop the verb from the URL).
3. Fix the ID parameters: in a new controller, route params should consistently refer to one resource.
4. Update imports, route names, form actions, JS calls and tests. Re-run tests.
5. Report the before/after: actions per controller (e.g. 19 actions over 2 controllers ≈ 9.5 avg → 6 controllers ≈ 3.2 avg).

## Patterns

1. **Nested resource → dedicated controller.** Listing a podcast's episodes: `PodcastEpisodesController@index` (not `PodcastController@listEpisodes`, and not piggybacking on `EpisodesController@index` with an optional ID). Convention: `PostCommentsController` for comments on a post; stop debating where it goes. Bonus: it attracts the other podcast-scoped endpoints (`create`, `store`) out of `EpisodesController`, so every ID in it is consistently a podcast ID.
2. **Independently editable property → its own resource.** A cover image edited via its own form: `PodcastCoverImageController@update`, route `PUT /podcasts/{id}/cover-image`. Even if it's not a table, it's a resource to the end user.
3. **Pivot records (subscribe/unsubscribe) → create/destroy of the pivot as a resource.** Ask: "After the user subscribes, what do I have that I didn't have before?" → a subscription. So `SubscriptionsController@store` (podcast ID comes in the request body) and `@destroy` (`DELETE /subscriptions/{id}`, found via `auth()->user()->subscriptions()->findOrFail($id)`). Give the pivot table a real name (`subscriptions`) and an Eloquent model; the model becomes a magnet for subscription-related behavior, slimming `User` and `Podcast`.
4. **State transition → create/destroy of the "stateful" resource.** Publishing: "what do I have now?" → a published podcast. `PublishedPodcastsController@store` (podcast ID in request) and `@destroy` (unpublish). Keep calling `$podcast->publish()` so events/behavior stay attached; don't inline `published_at` in a generic `update`. Return the resource as JSON so the front-end can update. Same idea for filtered subsets (e.g. popular episodes as their own resource instead of query-param juggling).
5. **Never merge two user intentions into one action** (e.g. making `update` handle both "edit details" and "replace cover image", or one `index` handling both nested and global listings). The controller would have to reverse-engineer the intent, and validation rules conflict.

## Bonus trick: setting multi-foreign-key models without leaking IDs

For a model with two foreign keys (e.g. `Subscription`), define mutators so callers pass models, not IDs:

```php
public function setUserAttribute(User $user)
{
    $this->attributes['user_id'] = $user->getKey();
    $this->setRelation('user', $user);
}
// same for setPodcastAttribute; then:
Subscription::create(['user' => $user, 'podcast' => $podcast]);
```
(Requires `user`/`podcast` to be fillable or set via a different path; check mass-assignment guards.)

## Guidance and caveats

- Prefer this over extracting service objects/command buses as a *first* move; small controllers with 1-2 private helpers feel simple on their own.
- Verbs like PUT/DELETE and resource names are part of the design; if the project uses a different convention (API-only, invokable single-action controllers), say so and adapt rather than forcing the rule.
- Name new controllers `<Parent><Child>Controller` (singular parent, plural child) or after the state/relationship (`PublishedPodcastsController`).
- Provide concrete route definitions, controller skeletons, and the moved code in the answer. Reply in the user's language; keep code identifiers in English.
