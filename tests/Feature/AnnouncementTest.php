<?php

namespace Tests\Feature;

use App\Models\Announcement;
use App\Models\User;
use Carbon\CarbonInterface;
use Illuminate\Foundation\Testing\RefreshDatabase;
use PHPUnit\Framework\Attributes\DataProvider;
use Tests\TestCase;

/**
 * Verifies announcement URL, access, rendering, and publication-date behavior.
 */
class AnnouncementTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Disables Vite asset generation for feature-test requests.
     */
    protected function setUp(): void
    {
        parent::setUp();

        $this->withoutVite();
    }

    /**
     * Confirms announcement routes use the model's slug as the URL segment.
     */
    public function testAnnouncementUrlUsesSlug(): void
    {
        $announcement = Announcement::factory()->create(['slug' => 'skinny-delicieuse']);

        $route = route('announcements.show', $announcement, false);

        $this->assertSame('/announcements/skinny-delicieuse', $route);
    }

    /**
     * Confirms guests can view an announcement and its title and description.
     */
    public function testGuestUserCanViewAnAnnouncement(): void
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

    /**
     * Confirms an unknown announcement slug returns a not-found response.
     */
    public function testUnknownAnnouncementSlugReturnsNotFound(): void
    {
        $this->get('/announcements/not-a-real-announcement')->assertNotFound();
    }

    /**
     * Confirms announcement title and description are escaped in the rendered page.
     */
    public function testAnnouncementContentIsEscapedInTheRenderedPage(): void
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

    /**
     * Provides descriptions at and below the threshold for hiding the read-more control.
     *
     * @return array<string, array{string}>
     */
    public static function announcementDescriptionsProvider(): array
    {
        return [
            'description with exactly 150 characters' => [str_repeat('a', 150)],
            'description with less than 150 characters' => [str_repeat('a', random_int(10, 149))],
        ];
    }

    /**
     * Confirms descriptions of 150 characters or less do not show the read-more control.
     */
    #[DataProvider('announcementDescriptionsProvider')]
    public function testSeeMoreButtonIsHiddenWhenDescriptionIs150CharactersOrLess(string $description): void
    {
        $announcement = Announcement::factory()->create(['description' => $description]);

        $route = route('announcements.show', $announcement);

        $this->get($route)
            ->assertOk()
            ->assertDontSee('Lire la suite')
            ->assertDontSee('<span id="dots">...</span>', false);
    }

    /**
     * Confirms descriptions longer than 150 characters show the read-more control.
     */
    public function testSeeMoreButtonIsVisibleWhenDescriptionIsMoreThan150Characters(): void
    {
        $announcement = Announcement::factory()->create(['description' => str_repeat('a', random_int(151, 1000))]);

        $route = route('announcements.show', $announcement);

        $this->get($route)
            ->assertOk()
            ->assertSee('Lire la suite')
            ->assertSee('<span id="dots">...</span>', false);
    }

    /**
     * Provides publication dates and their expected relative labels.
     *
     * @return array<string, array{CarbonInterface, string}>
     */
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

    /**
     * Confirms publication dates are displayed with the expected relative label.
     */
    #[DataProvider('publishedAtProvider')]
    public function testDisplayedPublishedDateIsFormatted(CarbonInterface $createdAt, string $expected): void
    {
        $announcement = Announcement::factory()->create(['created_at' => $createdAt]);

        $route = route('announcements.show', $announcement);

        $this->get($route)
            ->assertOk()
            ->assertSee("Publiée $expected");
    }

    /**
     * Confirms the displayed favorite count matches the number of times the announcement was added to favorites.
     */
    public function testAnnouncementDisplaysNumberOfTimesItWasAddedToFavorites(): void
    {
        $numberOfFavorites = random_int(1, 10);

        $users = User::factory()->count($numberOfFavorites)->create();
        $announcement = Announcement::factory()->create();

        $users->each(function (User $user) use ($announcement) {
            $announcement->addToFavorites($user);
        });

        $route = route('announcements.show', $announcement);

        $this->get($route)
            ->assertOk()
            ->assertSee("<span data-likes>$numberOfFavorites</span>", false)
            ->assertSee("<em>Favori · <b data-likes>$numberOfFavorites</b></em>", false);
    }
}
