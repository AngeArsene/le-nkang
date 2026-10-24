# Talk (Laravel 5.3, 2016) → modern Laravel

Check `composer.json` for the actual version before applying.

| Talk idiom | Modern equivalent |
|---|---|
| `use DatabaseMigrations;` | `use Illuminate\Foundation\Testing\RefreshDatabase;` (migrates once, wraps each test in a transaction) |
| `factory(User::class)->create()` | `User::factory()->create()` (Laravel 8+, class-based factories with `HasFactory` trait) |
| `$this->visit('/john')->see('text')` | `$this->get('/john')->assertOk()->assertSee('text')` |
| Acting as a user | `$this->actingAs($user)->post('/following/x')` |
| `$this->expectsEvents(NewFollower::class)` | `Event::fake([NewFollower::class]);` … `Event::assertDispatched(NewFollower::class, fn ($e) => $e->follower->is($follower) && $e->followed->is($followed));` |
| MailThief (`MailThief::hijack()`) | `Mail::fake();` … `Mail::assertSent(NewFollowerMail::class, fn ($m) => $m->hasTo($followed->email));` (use Mailables) |
| Raw `Mail::send('view', $data, fn ($m) => …)` | Mailable class with `envelope()` (subject) and `content()` (view); or a Notification |
| Event + listener `handle()` | Same; also consider Notifications (`Notification::fake()`, `Notification::assertSentTo`) |
| `phpunit.xml` env `DB_CONNECTION=sqlite`, `DB_DATABASE=:memory:` | Same, in `<php>` / `<env>` (often already present, commented, in new apps) |
| Mockery spies on facades | `Event::spy()` / `Mail::spy()` still exist; prefer the `fake()` + `assert*` helpers first |
| PHPUnit class tests | Optionally Pest: `it('sends a notification when a user is followed', function () { … });` |

## Notes
- `Mail::fake()` is the built-in fake the talk's author advocated (MailThief inspired it). Same principle: assert outcomes (who got what), not implementation calls.
- Event listeners can be auto-discovered in recent versions; the "forgot to wire the listener" failure caught by the acceptance test may instead come from a missing type-hint or queue config, so keep the acceptance test.
- Queued listeners/mailables: in tests with `Queue::fake()` assert pushed; to test end to end, run with the `sync` queue driver.
- Models need `$fillable`/`$guarded` considerations when using factories with mass assignment.
