<?php

namespace Tests\Feature;

use App\Models\Announcement;
use Carbon\CarbonInterface;
use Illuminate\Foundation\Testing\RefreshDatabase;
use PHPUnit\Framework\Attributes\DataProvider;
use Tests\TestCase;

class AnnouncementTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        $this->withoutVite();
    }

    public function test_announcement_url_uses_slug(): void
    {
        $announcement = Announcement::factory()->create(['slug' => 'skinny-delicieuse']);

        $route = route('announcements.show', $announcement, false);

        $this->assertSame('/announcements/skinny-delicieuse', $route);
    }

    public function test_guest_user_can_view_an_announcement(): void
    {
        $announcement = Announcement::factory()->create([
            'title' => 'Skinny Délicieuse',
            'description' => 'Envie de détente et de destresser je suis disponible pour réaliser vos envies et plaisirs sexuels.',
        ]);

        $route = route('announcements.show', $announcement);

        $this->get($route)
            ->assertOk()
            ->assertSee($announcement->title)
            ->assertSee($announcement->description);

        $this->assertGuest();
    }

    public function test_unknown_announcement_slug_returns_not_found(): void
    {
        $this->get('/announcements/not-a-real-announcement')->assertNotFound();
    }

    public function test_announcement_content_is_escaped_in_the_rendered_page(): void
    {
        $announcement = Announcement::factory()->create([
            'title' => '<script>alert("title")</script>',
            'description' => '<img src=x onerror=alert(1)>',
        ]);

        $route = route('announcements.show', $announcement);

        $this->get($route)
            ->assertOk()
            ->assertSee('&lt;script&gt;alert(&quot;title&quot;)&lt;/script&gt;', false)
            ->assertSee('&lt;img src=x onerror=alert(1)&gt;', false)
            ->assertDontSee('<script>alert("title")</script>', false)
            ->assertDontSee('<img src=x onerror=alert(1)>', false);
    }

    public static function announcementDescriptionsProvider(): array
    {
        return [
            'description with exactly 150 characters' => [str_repeat('a', 150)],
            'description with less than 150 characters' => [str_repeat('a', random_int(10, 149))],
        ];
    }

    #[DataProvider('announcementDescriptionsProvider')]
    public function test_see_more_button_is_hidden_when_description_is_150_characters_or_less(string $description): void
    {
        $announcement = Announcement::factory()->create(['description' => $description]);

        $route = route('announcements.show', $announcement);

        $this->get($route)
            ->assertOk()
            ->assertDontSee('Lire la suite')
            ->assertDontSee('<span id="dots">...</span>', false);
    }

    public function test_see_more_button_is_visible_when_description_is_more_than_150_characters(): void
    {
        $announcement = Announcement::factory()->create(['description' => str_repeat('a', random_int(151, 1000))]);

        $route = route('announcements.show', $announcement);

        $this->get($route)
            ->assertOk()
            ->assertSee('Lire la suite')
            ->assertSee('<span id="dots">...</span>', false);
    }

    public static function publishedAtProvider(): array
    {
        return [
            'published 1 day ago' => [now()->subDay(), 'il y a 1 jour'],
            'published 2 days ago' => [now()->subDays(2), 'il y a 2 jours'],
            'published 1 week ago' => [now()->subWeek(), 'il y a 1 semaine'],
            'published 2 weeks ago' => [now()->subWeeks(2), 'il y a 2 semaines'],
            'published 1 month ago' => [now()->subMonth(), 'il y a 1 mois'],
            'published 2 months ago' => [now()->subMonths(2), 'il y a 2 mois'],
            'published 1 year ago' => [now()->subYear(), 'il y a 1 an'],
            'published 2 years ago' => [now()->subYears(2), 'il y a 2 ans'],
        ];
    }

    #[DataProvider('publishedAtProvider')]
    public function test_displayed_published_date_is_formatted(CarbonInterface $createdAt, string $expected): void
    {
        $announcement = Announcement::factory()->create(['created_at' => $createdAt]);

        $route = route('announcements.show', $announcement);

        $this->get($route)
            ->assertOk()
            ->assertSee("Publiée $expected");
    }
}
